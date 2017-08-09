<?php


/**
 * Class Sassy
 */
class Sassy {

  function __construct() {

    // Bootstrap.
    add_action('after_setup_theme', array($this, 'setup'), 0);

    add_action('template_redirect', array($this, 'template_redirect'));

    if (!empty($_GET['doing-ajax']) && !defined('DOING_AJAX')) {
      define('DOING_AJAX', TRUE);
    }
  }


  /**
   * Theme main setup (supports, other functionalities, hooks)
   */
  function setup() {

    // Include theme settings.
    require_once __DIR__ . '/theme-settings.php';

    // MOVE THIS HERE
    add_action('init', array($this, 'theme_settings'));

    // Localization
    load_theme_textdomain('sassy', get_template_directory() . '/languages');

    // Add theme supports.
    add_theme_support('title-tag');
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
      'comment-list',
      'comment-form',
      'search-form',
      'gallery',
      'caption',
      'widgets',
    ));
    remove_theme_support('automatic-feed-links');

    // After plugin configuration is changed
    add_action('activated_plugin', array($this, 'activated_plugin'), 10, 2);
    add_action('deactivated_plugin', array($this, 'deactivated_plugin'), 10, 2);

    // Theme is activated
    add_action('after_switch_theme', array($this, 'after_switch_theme'));

    add_action('widgets_init', array($this, 'widgets_init'));
    add_action('wp_meta', array($this, 'wp_meta'));
    add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'), 100);
    add_action('wp_head', array($this, 'wp_head'), 10);
    add_action('sassy_before_layout', array($this, 'sassy_before_layout'));
    add_action('wp_footer', array($this, 'wp_footer'), 10);
    add_action('login_enqueue_scripts', array($this, 'login_enqueue_scripts'));

    add_action('admin_init', array($this, 'admin_init'));
    add_action('admin_head', array($this, 'admin_head'));
    add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    add_action('admin_menu', array($this, 'admin_menu'), SASSY_HOOK_LAST_PNUM);

    add_filter('use_default_gallery_style', '__return_false');
    if (!has_filter('widget_text', 'do_shortcode')) {
      add_filter('widget_text', 'do_shortcode');
    }
    add_filter('embed_oembed_html', array($this, 'embed_oembed_html'), 10, 4);

    add_filter('body_class', array($this, 'body_class'), SASSY_HOOK_LAST_PNUM, 2);
    add_filter('post_class', array($this, 'post_class'), SASSY_HOOK_LAST_PNUM, 3);
    add_filter('excerpt_more', array($this, 'excerpt_more'), SASSY_HOOK_LAST_PNUM);
    add_filter('next_posts_link_attributes', array($this, '_next_link_attributes'));
    add_filter('next_comments_link_attributes', array($this, '_next_link_attributes'));
    add_filter('previous_posts_link_attributes', array($this, '_prev_link_attributes'));
    add_filter('previous_comments_link_attributes', array($this, '_prev_link_attributes'));
    add_filter('get_comment_date', array($this, 'get_comment_date'), 10, 2);
    add_filter('comment_form_field_comment', array($this, 'comment_form_field_comment'), 1);
    add_filter('get_comment_author_link', array($this, 'get_comment_author_link'));
    add_filter('comment_form_default_fields', array($this, 'comment_form_default_fields'));
    add_filter('attachment_link', array($this, 'attachment_link'), 10, 2);
    add_filter('nav_menu_css_class', array($this, 'nav_menu_css_class'), 10, 4);
    add_filter('get_search_form', array($this, 'get_search_form'));
    add_filter('walker_nav_menu_start_el', array($this, 'walker_nav_menu_start_el'), SASSY_HOOK_LAST_PNUM, 4);
    add_filter('login_headerurl', array($this, 'login_headerurl'));

    // Good approach poor WordPress implementation
    // add_action('login_init', 'get_header');
    // add_action('login_footer', 'get_footer');
    // But back to reality
    add_filter('login_url', array($this, 'login_url'));

    // Add AJAX url.
    add_rewrite_tag('%sassy-ajax%', '^[a-zA-Z0-9_\-]+$' );

    // Fire theme setup action.
    do_action('sassy_after_theme_setup');

  }


  /**
   * Theme settings init
   */
  function theme_settings() {
    SassySettings::setup();
  }


  /**
   * Allow theme ajax requests
   */
  function template_redirect() {
    global $wp_query;

    // Theme AJAX handler
    $action = $wp_query->get('sassy-ajax');
    if ($action) {

      // Force AJAX request detection.
      if (!defined('DOING_AJAX')) {
        define('DOING_AJAX', TRUE);
      }

      // Theme export
      if ($action == 'settings-export') {
        if (get_current_user_id() && current_user_can('customize')) {
          sassy_settings_export(!empty($_GET['settings-only']));
        }
        else {
          @header('HTTP/1.0 403 Forbidden');
        }
      }

      // Autocomplete search
      if ($action == 'search-autocomplete') {
        _sassy_autocomplete_lookup();
      }

      // Other actions
      elseif (has_action('sassy_ajax_' . $action)) {
        do_action('sassy_ajax_' . $action);
      }

      exit;
    }

  }


  /**
   * After some plugin is activated
   *
   * @param $plugin
   * @param $network
   */
  function activated_plugin($plugin, $network) {
    // Clear cache
    _sassy_clear_theme_data('css');
  }


  /**
   * After some plugin is deactivated
   *
   * @param $plugin
   * @param $network
   */
  function deactivated_plugin($plugin, $network) {
    // Clear cache
    _sassy_clear_theme_data('css');
  }


  /**
   * After theme is being activated
   */
  function after_switch_theme() {
    // Clear cache
    _sassy_clear_theme_data('css');
  }


  /**
   * Implements widgets_init
   */
  function widgets_init() {
    require_once __DIR__ . '/widgets.php';
  }


  /**
   * Do admin panel actions.
   */
  function admin_init() {
    add_filter('mce_external_plugins', array($this, 'add_tinymce_plugin'));
    add_filter('mce_buttons_2', array($this, 'add_tinymce_button'), 0);
    add_filter('tiny_mce_before_init', array($this, 'tiny_mce_before_init'));
  }


  /**
   * Do admin menues
   */
  function admin_menu() {

    // Don't need of theme editor as users could break something :)
    remove_submenu_page('themes.php', 'theme-editor.php');
    add_theme_page(__('Tools', 'sassy'), __('Tools', 'sassy'), 'edit_theme_options', 'sassy-system', array($this, 'sassy_system_page'));
  }


  /**
   * Do when admin heads
   */
  function admin_head() {
    // Sassy help tab
    $screen = get_current_screen();
    if ($screen && ($screen->id == 'appearance_page_sassy-system' || $screen->post_type == 'sassy-layouts')) {
      include get_template_directory() . '/includes/admin-page-help.php';
      $screen->add_help_tab(array(
        'id' => 'sassy-help-conditions',
        'title' => __('Sassy conditions', 'sassy'),
        'callback' => 'sassy_help_conditions',
      ));
    }
  }


  /**
   * Import/Export admin panel theme page.
   */
  function sassy_system_page() {

    $messages = array();

    if (!empty($_POST['action']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'sassy-system-action')) {

      // Imports.
      if ($_POST['action'] == 'import') {
        if (!empty($_FILES['import_file'])) {
          if (sassy_settings_import($_FILES['import_file'], !empty($_POST['delete_current_layouts']))) {
            _sassy_clear_theme_data('css');
            $messages[] = __('Settings are imported successful.', 'sassy');
          }
        }
      }

      // Cache clear.
      elseif ($_POST['action'] == 'clear-cache') {
        _sassy_clear_theme_data('css');
        $messages[] = __('CSS caches are cleared', 'sassy');
      }

      // Install example settings.
      elseif ($_POST['action'] == 'install-example-content') {
        _sassy_install_example_settings();
        $messages[] = __('Example settings are imported', 'sassy');
      }

      // Uninstall.
      elseif ($_POST['action'] == 'delete-sassy-settings') {
        _sassy_clear_theme_data();
        $messages[] = __('All sassy settings (settings, layouts and compiled css files) are deleted. It could be called full Sassy uninstall.', 'sassy');
      }
    }

    if (!($active_tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_STRING))) {
      $active_tab = 'tools';
    }
    include get_template_directory() . '/includes/admin-page-system.php';
  }


  /**
   * Fixed logo for login window
   */
  function login_enqueue_scripts() {
    ?>
    <style>
    <?php if (get_header_image()):?>
      body.login div#login h1 a {
        display: block;
        width: 100%;
        background-image: url(<?php header_image(); ?>);
        margin: 0;
        padding: 0;
        background-size: contain;
      }
    <?php else:?>
      body.login div#login > h1 a {
        display: block;
        background: none;
        height: auto;
        width: 100%;
        text-indent: 0;
        margin: 0;
        max-width: 100%;
        <?php if (header_textcolor()):?>
          border: 3px solid <?php echo header_textcolor()?>;
          color: <?php echo header_textcolor()?>;
        <?php else:?>
          color: inherit;
        <?php endif?>
        font-size: 1.4em;
        text-align: center;
        padding: 0;
        text-decoration: none;
      }
    <?php endif?>
    </style>
  <?php
  }


  /**
   * Do on admin
   */
  function admin_enqueue_scripts() {
    // Styles
    wp_enqueue_style('sassy-admin', get_template_directory_uri() . '/assets/css/admin.css');
    sassy_enqueue_scss_files('editor');

    // Scripts
    wp_enqueue_script('sassy-admin', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'));
    $js_settings = array(
      'base' => trailingslashit(get_site_url()),
      'themeUrl' => get_template_directory_uri(),
      'settings' => array(),
    );
    foreach (SassySettings::options() as $name => $info) {
      if (!empty($info['type'])) {
        $js_settings['settings'][$name] = array(
          'type'  => $info['type'],
          'value' => isset($info['value']) ? $info['value'] : NULL,
        );
      }
    }
    wp_localize_script('sassy-admin', 'sassy', $js_settings);
  }


  /**
   * Enqueue theme scripts and styles.
   */
  function wp_enqueue_scripts() {

    // Load Google's webfonts if need.
    $gfonts = array();
    if (SassySettings::get('appearance_typography_gfontfamily')) {
      $gfonts[] = SassySettings::get('appearance_typography_gfontfamily') . ':400italic,700italic,400,700';
    }
    if (SassySettings::get('appearance_typography_gfontfamily_headings')) {
      $gfonts[] = SassySettings::get('appearance_typography_gfontfamily_headings') . ':400italic,700italic,400,700';
    }
    if ($gfonts) {
      wp_enqueue_style('google-web-fonts', sprintf('//fonts.googleapis.com/css?family=%s', urlencode(implode('|', $gfonts))), array(), NULL);
    }

    // Include the sass compiled files.
    if (sassy_enqueue_scss_files()) {
      wp_enqueue_style('sassy-scss');
    }
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.44274.js', array(), FALSE, TRUE);

    // Register 3rd party scripts.
    wp_register_script('mousewheel', get_template_directory_uri() . '/assets/js/jquery.mousewheel.min.js', array('jquery-core'), FALSE, TRUE);
    wp_register_script('masonry', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', array('jquery-core'), FALSE, TRUE);
    if (SassySettings::get('decoration_smooth_scrolling')) {
      wp_enqueue_script('simplr-smoothscroll', get_template_directory_uri() . '/assets/js/jquery.simplr.smoothscroll.min.js', array('jquery-core', 'mousewheel'), FALSE, TRUE);
    }

    // Include scripts and settings.
    wp_enqueue_script('sassy', get_template_directory_uri() . '/assets/js/script.js', array('jquery-core', 'modernizr'), (defined('SASSY_DEBUG') && SASSY_DEBUG ? microtime(1) : FALSE), TRUE);

    // JS settings.
    $js_settings = array(
      'settings' => array(
        'base' => trailingslashit(get_site_url()),
        'labels' => array(
          'menu' => __('Menu', 'sassy'),
        ),
      ),
    );
    foreach (SassySettings::options() as $key => $val) {
      if (!empty($val['export_js'])) {
        $js_settings['settings'][$key] = $val['value'];
      }
    }
    // Allow to interact with the settings.
    $js_settings['settings'] = apply_filters('sassy_js_settings', $js_settings['settings']);
    if ($js_settings) {
      wp_localize_script('sassy', 'sassy', $js_settings);
    }

    // Add comment's js files only when need.
    if (is_singular() && comments_open() && get_option('thread_comments')) {
      wp_enqueue_script('comment-reply');
    }

  }


  /**
   * Implements wp_meta
   */
  function wp_meta() {

    global $paged;

    // Skip SEO friendly metas.
    if (sassy_is_login_page() || is_admin()) {
      wp_no_robots();
    }

    // Add noindex because these pages could cause duplicate content.
    elseif (!is_archive() && (!empty($_GET['orderby']) || !empty($_GET['order']) || $paged > 1)) {
      wp_no_robots();
    }

  }


  /**
   * Theme head
   */
  function wp_head() {
    echo '<!-- sassy_html_inject_css -->' . SassySettings::get('custom_html_head');
  }


  /**
   * Theme after body
   */
  function sassy_before_layout() {
    echo SassySettings::get('custom_html_body');
  }


  /**
   * Theme footer
   */
  function wp_footer() {
    echo SassySettings::get('custom_html_footer');
  }


  /**
   * Rewrite search form
   */
  function get_search_form($form) {
    $search = '<input type="submit" class="search-submit" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />';
    $replace = '<button type="submit" class="search-submit">' . esc_attr_x( 'Search', 'submit button' )  . '</button>';
    return str_replace($search, $replace, $form);
  }


  /**
   * Comments form alter
   */
  function comment_form_default_fields($fields)  {
    if (isset($fields['url'])) {
      unset($fields['url']);
    }
    return $fields;
  }


  /**
   * Body classes
   */
  function body_class($classes, $class) {
    if (is_customize_preview()) {
      $classes[] = 'sassy-theme-preview';
    }
    if (is_singular()) {
      $classes[] = 'sassy-view-singular';
    }
    else {
      $classes[] = 'sassy-view-loop';
    }
    $classes = array_unique($classes);
    return $classes;
  }


  /**
   * Post classes
   */
  function post_class($classes, $class, $post_id) {
    $classes[] = 'entry';
    if (is_singular()) {
      $classes[] = 'entry-singular';
    }
    else {
      $classes[] = 'entry-archive';
    }
    $classes = array_unique($classes);
    return $classes;
  }


  /**
   * Read more
   */
  function excerpt_more($read_more = '') {
    $option = SassySettings::get('components_read_more_string');
    if ($option) {
      $read_more = $option;
      return ' <span class="more">' . $read_more . '</span>';
    }
    else {
      return '';
    }
  }


  /**
   * Tweak pre/next links
   */
  function _next_link_attributes() {
    return ' class="button next" rel="next" ';
  }


  /**
   * Tweak pre/next links
   */
  function _prev_link_attributes() {
    return ' class="button prev" rel="prev" ';
  }


  /**
   * Override the default get comment date and show like a human
   */
  function get_comment_date($date, $d) {
    if ($d != 'c' && SassySettings::get('components_time_format') == 'human') {
      $date = sprintf(__('%s ago', 'sassy'), human_time_diff(date('U', strtotime($date)), current_time('timestamp')));
    }
    return $date;
  }


  /**
   * Add avatar to comment forms
   */
  function comment_form_field_comment($comment_field) {
    return
      '<div class="comment-form-commenter-avatar">' .
      get_avatar(get_current_user_id(), SassySettings::get('components_comment_avatar_size', 64)) .
      '</div>' .
      $comment_field;
  }


  /**
   * Rewrite comment author links
   */
  function get_comment_author_link($output) {
    $output = str_replace('<a ', '<a itemprop="url" ', $output);
    return $output;
  }


  /**
   * Wrap media elements to div wrapper
   */
  function embed_oembed_html($html, $url, $attr, $post_ID ) {
    return '<div class="media-container">' . $html . '</div>';
  }


  /**
   * Fix attachment links
   */
  function attachment_link($link, $post_id) {
    if (SassySettings::get('post_types_attachments_visits')) {
      return $link;
    }
    else {
      $parent = wp_get_post_parent_id($post_id);
      if ($parent) {
        return get_permalink($parent);
      }
      else {
        return NULL;
      }
    }
  }


  /**
   * Fix current menu class for custom menues
   */
  function nav_menu_css_class($classes, $item, $args, $depth) {

    // Fix homepage selecting.
    if (rtrim($item->url, '/') == rtrim(home_url(), '/')) {
      $key = array_search('current-menu-item', $classes);
      if ($key !== FALSE) {
        unset($classes[$key]);
        return $classes;
      }
    }

    // Other items.
    if (array_key_exists('item_class', $args)) {
      if (is_scalar($args->item_class)) {
        $classes = array($args->item_class);
      }
      else {
        $classes = $args->item_class;
      }
      global $wp;

      static $rurl = NULL;
      static $hurl = NULL;
      if ($rurl === NULL) {
        $rurl = trailingslashit(home_url($wp->request));
      }
      if ($hurl === NULL) {
        $hurl = trailingslashit(home_url());
      }
      $iurl = trailingslashit($item->url);

      if (strpos($iurl, $hurl) !== 0) {
        $iurl = home_url($iurl);
      }

      if ( ($iurl == $hurl && $rurl == $iurl ) || (strpos($rurl, $iurl) === 0 && $hurl != $iurl) ) {
        $classes[] = 'header-nav-menu-item-current';
      }
    }

    return $classes;
  }


  /**
   * Tweak nav menues
   */
  function walker_nav_menu_start_el($item_output, $item, $depth, $args) {
    if ($depth == 0 && !empty($item->description)) {
      $item_output .= '<div class="description">' . $item->description . '</div>';
    }
    if ($item && $item->type == 'post_type' && $item->object == 'sassy-layouts') {
      if ($depth > 0) {
        return NULL;
      }
      else {
        $layout_content = sassy_layout_render($item->object_id, FALSE);
        if ($layout_content) {
          // TODO eliminate the siteorigin hardcoded id here
          $item_output = '<a href="#pl-' . $item->object_id . '">' . $item->title . '</a>' . $layout_content;
        }
        else {
          return NULL;
        }
      }
    }
    return $item_output;
  }


  /**
   * Override login page header url
   */
  function login_headerurl() {
    return home_url();
  }


  /**
   * Attach tinymce script
   */
  function add_tinymce_plugin($plugin_array) {
    $plugin_array['sassy'] = get_template_directory_uri() . '/assets/js/tinymce-buttons.js';
    return $plugin_array;
  }


  /**
   * Add the button key for address via JS
   */
  function add_tinymce_button($buttons) {
    $buttons = array_merge(array_slice($buttons, 0, 7), array('sassy_fontawesome_button'), array_slice($buttons, 7));
    $buttons = array_merge(array_slice($buttons, 0, 1), array('styleselect'), array_slice($buttons, 1));
    return $buttons;
  }


  /**
   * Callback function to filter the MCE settings
   *
   * @param $init_array
   *
   * @return mixed
   */
  function tiny_mce_before_init( $init_array ) {
    $style_formats = array(
      array(
        'title' => sprintf(__('Text in columns (%s)', 'sassy'), 2),
        'block' => 'div',
        'classes' => 'columns-2text',
        'wrapper' => TRUE,
      ),
      array(
        'title' => sprintf(__('Text in columns (%s)', 'sassy'), 3),
        'block' => 'div',
        'classes' => 'columns-text',
        'wrapper' => TRUE,
      ),
      array(
        'title' => sprintf(__('Text in columns (%s)', 'sassy'), 4),
        'block' => 'div',
        'classes' => 'columns4-text',
        'wrapper' => TRUE,
      ),
      array(
        'title' => __('Widget title'),
        'block' => 'div',
        'classes' => 'widget-title',
        'wrapper' => TRUE,
      )
    );
    $init_array['style_formats'] = json_encode($style_formats);
    return $init_array;

  }


  /**
   * Override wordpress login url
   */
  function login_url($url) {
    $login_page_id = SassySettings::get('login_page');
    if ($login_page_id) {
      $new_url = get_post_permalink($login_page_id);
      if ($new_url) {
        $url = $new_url;
      }
    }
    return $url;
  }


}

return new Sassy();
