<?php

/**
 * @file
 * Theme helpers
 */


/**
 * Complete erease every saassy settings and layouts
 *
 * @param array|string $params
 *
 * @return bool
 */
function _sassy_clear_theme_data($params = '') {

  if (!$params) {
    $params = array('layouts', 'theme_mods', 'css');
  }
  if (!is_array($params)) {
    $params = explode(',', $params);
  }


  // Layouts
  if (in_array('layouts', $params)) {
    $layouts = get_posts('post_type=sassy-layouts&numberposts=1000&post_status=any');
    foreach ($layouts as $layout) {
      wp_delete_post($layout->ID, TRUE);
    }
  }

  // Theme mods
  if (in_array('theme_mods', $params)) {
    $all_mods = get_theme_mods();
    foreach ($all_mods as $mod_name => $mod_value) {
      remove_theme_mod($mod_name);
    }
  }

  // Compiled CSS files
  if (in_array('css', $params)) {
    remove_theme_mod('_css_revision');
    $sassy_css_path = WP_CONTENT_DIR . '/cache/sassy-css/';
    if (is_dir($sassy_css_path)) {
      $files = glob($sassy_css_path . '/n' . get_current_blog_id() . '-*.css');
      if ($files) {
        foreach ($files as $file) {
          unlink($file);
        }
      }
    }
  }

  return TRUE;
}


/**
 * Initialize $wp_filesystem global
 *
 * @return bool
 */
function _sassy_init_wp_filesystem() {
  global $wp_filesystem;
  if (!$wp_filesystem) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    return WP_Filesystem();
  }
  return TRUE;
}


/**
 *
 * @param bool $reset_cache
 * @return array
 */
function sassy_get_google_fonts_list($reset_cache = FALSE) {
  $list = get_theme_mod('_sassy_google_fonts_list');
  if ($list && !$reset_cache) {
    return $list;
  }
  else {
    $args = array(
      'timeout' => 5,
    );
    $response = wp_safe_remote_request('http://static.scripting.com/google/webFontNames.txt', $args);
    if ($response && !empty($response['response']['code']) && $response['response']['code'] == 200 && !empty($response['body'])) {
      $list = explode("\r", $response['body']);
      $list = array_filter($list);
      $list = array_combine($list, $list);
      set_theme_mod('_sassy_google_fonts_list', $list);
      return $list;
    }
    else {
      return array();
    }
  }
}


/**
 * Enqueue compiled scss files or just the files
 *
 * @param string $mode
 *
 * @return bool|WP_Error
 */
function sassy_enqueue_scss_files($mode = '') {

  $scss_path = get_template_directory() . '/assets/scss';

  $scss_css_dir = 'cache/sassy-css';

  $cssfilename = 'n' . get_current_blog_id() . '-' . get_stylesheet();
  if (get_stylesheet() != 'sassy') {
    $cssfilename .= '-sassy';
  }

  if ($mode == 'editor') {
    $debug = (defined('SASSY_DEBUG') && SASSY_DEBUG);
    $revision = get_theme_mod('_css_revision', NULL);
    $css_file = $scss_css_dir . '/' . $cssfilename . '.editor.css';
  }
  else {

    $debug = is_customize_preview() || (defined('SASSY_DEBUG') && SASSY_DEBUG);

    if (is_customize_preview()) {
      $revision = 'customizer-' . date('Ymd.His');
      $css_file = $scss_css_dir . '/' . $cssfilename . '.customizer.css';
    }
    elseif ($debug) {
      $revision = 'debug-' . date('Ymd.His');
      $css_file = $scss_css_dir . '/' . $cssfilename . '.debug.css';
    }
    else {
      $revision = get_theme_mod('_css_revision', NULL);
      $css_file = $scss_css_dir . '/' . $cssfilename . '.css';
    }
  }

  $css_file_path = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . $css_file;
  $css_file_url = content_url($css_file);

  $need_regenerate = !file_exists($css_file_path) || (!defined('SASSY_DISABLE_CSS_REGENERATE') && $debug || !$revision);

  if ($need_regenerate) {

    $css_file_dir = dirname($css_file_path);
    if (!file_exists($css_file_path) && !wp_mkdir_p($css_file_dir)) {
      return new WP_Error('sassy-scss', __('Can\'t create directory for css files.', 'sassy'));
    }

    // If there is some module that already included scss or other scss processor,
    // then is bad but we could try to use it.
    if (!class_exists('scssc', FALSE)) {
      require_once(__DIR__ . '/scss.php');
    }

    // Inutialize SASS processor's class.
    $scss = new scssc($scss_path, WP_CONTENT_DIR . DIRECTORY_SEPARATOR . $scss_css_dir . DIRECTORY_SEPARATOR);

    $paths = array(
      $scss_path,
    );

    if (is_child_theme()) {
      $paths[] = get_stylesheet_directory();
      if (is_dir(get_stylesheet_directory() . '/assets/scss')) {
        $paths[] = get_stylesheet_directory() . '/assets/scss';
      }
    }

    $paths = apply_filters('sassy_scss_paths', $paths);
    $scss->setImportPaths($paths);
    $settings = SassySettings::options();
    $_variables = array(
      'theme_assets' => '"' . get_template_directory_uri() . '/assets"',
    );
    foreach ($settings as $setting_id => $setting_info) {
      if (!empty($setting_info['export_scss'])) {
        if ($setting_info['value'] === NULL || $setting_info['value'] == '') {
          $val = 'null';
        }
        else {
          $val = $setting_info['value'];
        }
        $_variables[$setting_id] = $val;
      }
    }
    $_variables = apply_filters('sassy_scss_settings', $_variables);

    if ($debug) {
      echo "\n<!-- SCSS VARS: " . var_export($_variables, TRUE) . " -->\n";
    }
    $_variables_code = '';
    foreach ($_variables as $key => $val) {
      $_variables_code .= "\n\${$key}: {$val};";
    }

    if (!$revision) {
      $revision = date('Ymd.His');
    }
    $code = "/* Revision: {$revision} */\n";
    if ($debug) {
      $scss->setFormatter('scss_formatter_nested');
      $code .= "\n\n/**************************************\n * Variables:\n **************************************\n";
      $code .= $_variables_code;
      $code .= "\n\n /***************************************/\n\n";
    }
    else {
      $scss->setFormatter('scss_formatter_crunched');
    }
    $code .= $_variables_code;
    if ($mode == 'editor') {
      $code .= "@import 'editor.scss';";
    }
    else {
      $code .= "@import 'default.scss';";
    }
    $code .= sassy_fontawesome_icons_scss();

    // Custom CSS is SASS
    if (SassySettings::get('custom_css_sass')) {
      $code .= "\n\n/*****************************************\n * Custom SASS code:\n **************************************/\n";
      $code .= SassySettings::get('custom_css');
    }

    try {
      $css_code = @$scss->compile($code);
    }
    catch (Exception $e) {
      if ($debug) {
        $ee = print_r(explode("\n", trim($e)), TRUE);
        echo "\n<!-- SCSS ERRORS:\n$ee\n -->\n";
      }
      wp_register_style('sassy-scss', $css_file_url, array(), $revision);
      return new WP_Error('sassy-scss', sprintf(__('Problem while processing the scss code [%s].', 'sassy'), print_r($e, TRUE)));
    }

    // Custom CSS is CSS
    if (!SassySettings::get('custom_css_sass')) {
      $css_code .= ' ' . SassySettings::get('custom_css');
    }

    _sassy_init_wp_filesystem();
    global $wp_filesystem;
    if ($wp_filesystem && $wp_filesystem->put_contents($css_file_path, $css_code)) {
      if (!$debug) {
        set_theme_mod('_css_revision', $revision);
      }
    }
    else {
      if ($mode != 'editor') {
        echo '<style>' . $css_code . '</style>';
      }
      return FALSE;
    }
  }
  if ($mode == 'editor') {
    add_editor_style($css_file_url);
  }
  else {
    wp_register_style('sassy-scss', $css_file_url, array(), $revision);
  }
  return TRUE;
}


/**
 * Generate FontAwesome Icons SCSS
 *
 * @return string
 */
function sassy_fontawesome_icons_scss() {

  _sassy_init_wp_filesystem();
  global $wp_filesystem;

  if ($wp_filesystem) {
    $vars = $wp_filesystem->get_contents(get_template_directory() . '/assets/content/fontawesome-vars.json');
    $vars = json_decode($vars);
  }
  else {
    return;
  }

  if (!$vars) {
    return '';
  }

  $scss_code = '';
  foreach ($vars as $var) {
    $chr = str_replace("\f", '\f', $var[1]);
    $scss_code .= "\n.fa--i-{$var[0]},.fa-{$var[0]}:before { content: '$chr' } .fa--{$var[0]}:before { @extend .fa; content: '$chr' }";
  }
  return $scss_code;
}


/**
 * Main sassy obfuscator
 *
 * @param string $content
 *
 * @return string
 */
function _sassy_ob_html($content = '') {
  return strtr($content, array(
    '<!-- sassy_html_inject_css -->' => apply_filters('sassy_html_inject_css', ''),
  ));
}


/**
 * Output HTML tag attributes
 */
function sassy_html_attributes() {

  $attributes = array(
    'schema' => 'http://schema.org/',
    'itemscope' => 'itemscope',
  );

  // Itemtype.
  if (is_singular('post')) {
    $attributes['itemtype'] = 'Article';
  }
  elseif (is_author()) {
    $attributes['itemtype'] = 'ProfilePage';
  }
  elseif (is_search()) {
    $attributes['itemtype'] = 'SearchResultsPage';
  }
  else {
    $attributes['itemtype'] = 'WebPage';
  }

  $attributes = apply_filters('sassy_html_attributes', $attributes);

  foreach ($attributes as $key => $val) {
    if (is_array($val) || is_object($val)) {
      $val = implode(' ', $val);
    }
    printf(' %s="%s"', esc_attr($key), esc_attr($val));
  }

}


/**
 * Output attributes for posts article tag.
 *
 * @param array
 */
function sassy_post_attributes($atts = array()) {
  $attributes = array_merge_recursive($atts, array(
    'class' => get_post_class(),
  ));
  $attributes = apply_filters('sassy_post_attributes', $attributes);

  foreach ($attributes as $key => $val) {
    if (is_array($val) || is_object($val)) {
      $val = implode(' ', $val);
    }
    printf(' %s="%s"', esc_attr($key), esc_attr($val));
  }
}


/**
 * Sanitize CSS colors
 *
 * @param $value
 * @return null|string
 */
function sassy_sanitize_color($value) {
  $value = trim($value, '#');
  if ($value && preg_match('#^([a-f0-9]{3})([a-f0-9]{3})?$#i', $value)) {
    return '#' . $value;
  }
  else {
    return NULL;
  }
}


/**
 * Render mesuremenet selector as
 * HTML select form tag
 *
 * @param $name
 * @param $value
 */
function sassy_measurement_selector($name, $value) {
  echo '<select name="' . esc_attr($name) . '">';
  $list = apply_filters('sassy_supported_measurements', array('px', '%'));
  foreach ($list as $m) {
    echo '<option value="' . esc_attr($m) . '"' . selected($value, $m) . '>' . esc_html($m) . '</option>';
  }
  echo '</select>';
}


/**
 * Get list of theme available breakpoints
 *
 * @return array
 */
function sassy_available_breakpoints() {
  $options = array(
    ''     => __('No breakpoint', 'sassy'),
    '1824' => __('1824px - Very Large Screens', 'sassy'),
    '1224' => __('1224px - Desktop and Laptop', 'sassy'),
    '1024' => __('1024px - Popular Tablet Landscape', 'sassy'),
    '960'  => __('960px - Netbooks', 'sassy'),
    '800'  => __('800px - New Tablet Portrait', 'sassy'),
    '768'  => __('768px - Popular Tablet Portrait', 'sassy'),
    '600'  => __('600px - Popular Breakpoint in Headway', 'sassy'),
    '568'  => __('568px - iPhone 5 Landscape', 'sassy'),
    '480'  => __('480px - iPhone 3 &amp; 4 Landscape', 'sassy'),
    '320'  => __('320px - iPhone 3 &amp; 4 &amp; 5 &amp; Android Portrait', 'sassy'),
  );
  return apply_filters('sassy_available_breakpoints', $options);
}


/**
 * Export all theme settings
 *
 * @param $settings_only
 */
function sassy_settings_export($settings_only = FALSE) {

  $settings = new stdClass;
  $settings->layouts = get_posts('post_type=sassy-layouts');
  foreach ($settings->layouts as &$layout) {
    $layout->guid = '';
    $layout->_custom_meta = get_post_meta($layout->ID);
    unset($layout->_custom_meta['_edit_lock']);
    unset($layout->_custom_meta['_edit_last']);
  }

  $settings->theme_mods = get_theme_mods();
  unset($settings->theme_mods['_sassy_google_fonts_list']);
  unset($settings->theme_mods['_css_revision']);

  // Download file.
  $filename = get_bloginfo('name') . '-' . date('YmdHi');
  if ($settings_only) {
    $filename .= '.settingsonly';
  }
  $filename .= '.sassy';
  @header('Cache-Control: no-cache, must-revalidate');
  @header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
  @header('Content-Type: plain/text; charset=UTF-8');
  @header('Content-Disposition: attachment; filename="' . addslashes($filename) . '"');
  echo serialize($settings);
  exit;
}


/**
 * Import all sassy settings
 *
 * $data param could be the settings string, or PHP $_FILE array
 *
 * @param $data
 * @param $delete_current_layouts
 *
 * @return bool
 */
function sassy_settings_import($data, $delete_current_layouts = TRUE) {
  global $wpdb;

  _sassy_init_wp_filesystem();
  global $wp_filesystem;
  if (!$wp_filesystem) {
    return false;
  }

  // Check if it is $_FILE array
  if (is_array($data) && !empty($data['tmp_name']) && !empty($data['size']) && empty($data['error'])) {
    $data = $wp_filesystem->get_contents($data['tmp_name']);
  }

  elseif (is_string($data) && strrpos($data, '.sassy')) {
    $data = $wp_filesystem->get_contents($data);
  }

  $import_status = FALSE;
  $data = maybe_unserialize($data);

  if ($data) {

    // Delete all current layouts.
    if ($delete_current_layouts) {
      $layouts = get_posts('post_type=sassy-layouts&numberposts=1000&post_status=any');
      foreach ($layouts as $layout) {
        wp_delete_post($layout->ID, TRUE);
      }
    }

    // Layouts.
    if (!empty($data->layouts)) {

      // Create DB with mappings.
      $old_ids_to_new = array();
      $posts_parents = array();

      // Import layouts.
      foreach ($data->layouts as $layout) {
        $postdata = (array) $layout;
        unset($postdata['ID']);
        unset($postdata['post_parent']);
        unset($postdata['_custom_meta']);
        $post_id = wp_insert_post($postdata, FALSE);
        if ($post_id) {
          $old_ids_to_new[$layout->ID] = $post_id;
          $posts_parents[$layout->ID] = $layout->post_parent;
          foreach ($layout->_custom_meta as $key => $val) {
            $meta_val = maybe_unserialize($val);
            if (is_array($meta_val)) {
              foreach ($meta_val as $meta_val_single) {
                add_post_meta($post_id, $key, maybe_unserialize($meta_val_single), TRUE);
              }
            }
          }
        }
      }

      // Fix post parents.
      foreach ($posts_parents as $old_post_id => $old_parent) {
        if (!empty($old_ids_to_new[$old_parent])) {
          $query = $wpdb->prepare("UPDATE {$wpdb->posts} SET post_parent = %d WHERE ID = %d LIMIT 1", $old_ids_to_new[$old_parent], $old_ids_to_new[$old_post_id]);
          $wpdb->query($query);
        }
      }

      $import_status = TRUE;
    }

    // Theme mods.
    if (!empty($data->theme_mods)) {
      foreach ($data->theme_mods as $key => $val) {
        set_theme_mod($key, $val);
      }
      $import_status = TRUE;
    }
  }

  return $import_status;
}


/**
 * Install Sassy theme example settings
 *
 * @return bool
 */
function _sassy_install_example_settings() {
  if (get_current_user_id() && current_user_can('customize')) {
    sassy_settings_import(get_template_directory() . '/assets/content/example-settings.sassy');
    _sassy_clear_theme_data('css');
    return TRUE;
  }
  return FALSE;
}


/**
 * Searching method
 */
function _sassy_autocomplete_lookup() {

  global $wpdb;

  // Set browser cache.
  $expires = HOUR_IN_SECONDS * 6;
  header('Pragma: public');
  header('Cache-Control: maxage=' . $expires);
  // Header is required for w3tc to works.
  header('Content-Type: text/html; charset=UTF-8');
  header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');

  $string = empty($_REQUEST['q']) || !is_scalar($_REQUEST['q']) ? '' : trim($_REQUEST['q'], ' -/_');
  $autocomplete_limit = empty($_REQUEST['limit']) || !is_numeric($_REQUEST['limit']) ? 10 : $_REQUEST['limit'];
  $autocomplete_types = empty($_REQUEST['post_type'])
    ? array_merge(array('post', 'page'), get_post_types(array('_builtin' => FALSE, 'public' => TRUE), 'names'))
    : (is_string($_REQUEST['post_type']) ? explode(',', $_REQUEST['post_type']) : (array) $_REQUEST['post_type']);

  $post_types = get_post_types(array('public' => TRUE, 'exclude_from_search' => FALSE), 'names');
  $autocomplete_types = array_intersect($post_types, $autocomplete_types);
  if (!$autocomplete_types) {
    exit;
  }

  $autocomplete_types_str = '';
  foreach ($autocomplete_types as $val) {
    $autocomplete_types_str[] = "'{$val}'";
  }
  $autocomplete_types_str = implode(', ', $autocomplete_types_str);

  $text_pattern = '%' . wp_filter_kses($string, '') . '%';

  // Get most relevant results.
  $querystr = "
    SELECT ID, post_title, (COUNT(comment_ID) / ((NOW()-post_date)/60/60/24/7)) score
    FROM {$wpdb->posts}
    LEFT JOIN {$wpdb->comments} ON ID = comment_post_ID
    WHERE
      post_type IN ({$autocomplete_types_str})
      AND (
        post_title LIKE %s
        OR post_name LIKE %s
        OR ID LIKE %s
        OR post_excerpt LIKE %s
      )
      AND post_status IN ('publish')
    GROUP BY ID
    ORDER BY score DESC, post_date DESC
    LIMIT %d";

  $query = $wpdb->prepare($querystr, $text_pattern, $text_pattern, $text_pattern, $text_pattern, $autocomplete_limit);

  $posts = $wpdb->get_results($query);
  $output = '';
  $site_search_url = home_url() .'?s=' . $string . '&type=' . implode(',', $autocomplete_types);
  $output .= '<li class="search-for"><a href="' . esc_attr($site_search_url) . '"> ' . __('Search for:') . ' ' . esc_html($string) . '&hellip; </a></li>';
  $post_not_in = array();
  $empty = TRUE;
  foreach ($posts as $post) {
    $empty = FALSE;
    $output .= '<li><a href="' . get_permalink($post->ID) . '">';
    $output .= get_the_post_thumbnail($post->ID, 'thumbnail');
    $output .= $post->post_title;
    $output .= '</a></li>';
    $post_not_in[] = $post->ID;
  }

  // Reach the limit with less relevant resuts.
  if (count($posts) < $autocomplete_limit) {
    $querystr = "
      SELECT ID, post_title, (COUNT(comment_ID) / ((NOW()-post_date)/60/60/24/7)) score
      FROM {$wpdb->posts}
      LEFT JOIN {$wpdb->comments} ON ID = comment_post_ID
      WHERE
        post_type IN ({$autocomplete_types_str})
        AND post_content LIKE %s
        AND post_status IN ('publish')
        ";
    if ($post_not_in) {
      $querystr .= "
      AND ID NOT IN(" . implode($post_not_in, ',') . ")";
    }
    $querystr .= "
      GROUP BY ID
      ORDER BY score DESC, post_date DESC
    LIMIT %d";
    $query = $wpdb->prepare($querystr, $text_pattern, ($autocomplete_limit - count($posts)));
    $posts = $wpdb->get_results($query);
    foreach ($posts as $post) {
      $empty = FALSE;
      $output .= '<li><a href="' . get_permalink($post->ID) . '">';
      $output .= get_the_post_thumbnail($post->ID, 'thumbnail');
      $output .= $post->post_title;
      $output .= '</a></li>';
    }
  }
  if ($empty) {
    echo '<li class="no-posts-found">' . __('No posts found.') . '</li>';
  }
  echo $output;
}
