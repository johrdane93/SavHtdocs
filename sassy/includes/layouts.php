<?php


/**
 * Check if post is from post type sassy-layouts
 *
 * @param int|WP_Object $post
 *
 * @return bool
 */
function sassy_post_is_layout($post) {
  static $cache = array();
  if (is_a($post, 'WP_Post')) {
    return $post->post_type == 'sassy-layouts';
  }
  elseif (is_numeric($post)) {
    if (!isset($cache[$post])) {
      $cache[$post] = get_post_type($post);
    }
    return $cache[$post] == 'sassy-layouts';
  }
  else {
    return FALSE;
  }
}


/**
 * Check if given layout post id is layout root
 *
 * @param int @post_id
 *
 * @return bool
 */
function sassy_layout_is_root($post_id) {
  return ($post_id == sassy_get_root_layout_id());
}


/**
 * Get sassy layout root layout
 *
 * @return int|NULL
 */
function sassy_get_root_layout_id() {

  if (defined('SASSY_NOLAYOUTING_PLUGIN')) {
    return NULL;
  }

  static $root_layout_id = NULL;
  if ($root_layout_id === NULL) {
    $layout_id = sassy_get_request_layout_id('fallback_to_default=1');
    $ancestors = get_post_ancestors($layout_id);
    if ($ancestors) {
      $root_layout_id = array_shift($ancestors);
    }
    else {
      $root_layout_id = $layout_id;
    }
  }
  return $root_layout_id;
}


/**
 * Locate layout depending on current WP request.
 *
 * args:
 *   fallback_to_default <bool>
 *      if no layout is found then fallback to default layout
 *   final <bool>
 *      found final content type related layout
 *   post <int|WP_Post>
 *      found layout related to post (post type, variant)
 *
 * @param string|array $args
 *
 * @return int|null
 *   WP_Post ID or NULL if not matched anything
 */
function sassy_get_request_layout_id($args = '') {

  if (defined('SASSY_NOLAYOUTING_PLUGIN')) {
    return NULL;
  }

  global $wp_query;

  $defaults = array(
    'fallback_to_default' => FALSE,
    'final' => NULL,
    'post' => NULL,
  );
  $args = wp_parse_args($args, $defaults);

  // Caching the whole query.
  static $cache = array();
  $cid = md5(serialize($args) . serialize($wp_query));
  if (isset($cache[$cid])) {
    return $cache[$cid];
  }
  $cache[$cid] = NULL;
  $layout_id =& $cache[$cid];

  if ($args['post']) {
    $args['post'] = get_post($args['post']);
  }

  global $wpdb;

  // If current user is admin, then give high priority to drafts.
  if (current_user_can('customize')) {
    $query_str_post_status = ' IN (\'draft\', \'publish\') ';
    $query_str_order = ' post.menu_order DESC, FIELD(post_status, \'draft\', \'publish\')';
  }
  else {
    $query_str_post_status = ' = \'publish\' ';
    $query_str_order = ' post.menu_order DESC';
  }

  // Cache query in static
  static $layouts = NULL;
  if ($layouts === NULL) {

    $query = "
      SELECT
        post.ID
        ,selection_rule.post_id
        ,post.post_title
        ,post.post_status
        ,selection_rule.meta_value selection_rule
        ,selection_rule_condition.meta_value selection_rule_condition
        ,export_as_template.meta_value export_as_template
        ,layout_type.meta_value layout_type

      FROM {$wpdb->posts} post

      LEFT JOIN {$wpdb->postmeta} export_as_template
        ON export_as_template.post_id = post.ID
        AND export_as_template.meta_key = '_sassy_layout_as_template'

      INNER JOIN {$wpdb->postmeta} selection_rule
        ON selection_rule.post_id = post.ID
        AND selection_rule.meta_key = '_sassy_layout_selection_rule'

      LEFT JOIN {$wpdb->postmeta} selection_rule_condition
        ON selection_rule_condition.post_id = post.ID
        AND selection_rule_condition.meta_key = '_sassy_layout_selection_rule_condition'

      LEFT JOIN {$wpdb->postmeta} layout_type
        ON layout_type.post_id = post.ID
        AND layout_type.meta_key = '_sassy_layout_type'

      WHERE
        post.post_type = 'sassy-layouts'
        AND post.post_status {$query_str_post_status}
      HAVING
        layout_type = 'site'
      ORDER BY {$query_str_order};";

    $layouts = $wpdb->get_results($query);
  }

  if ($layouts) {

    // Handle posts that have templates.
    if ($args['fallback_to_default'] && is_singular()) {
      $layout_template_id = get_post_meta(get_the_ID(), '_sassy_use_template', TRUE);
      foreach ($layouts as $rule) {
        if ($rule->export_as_template && $rule->post_id == $layout_template_id) {
          $layout_id = $layout_template_id;
          return $layout_id;
        }
      }
    }

    // Cycle over all templates.
    $default = NULL;
    foreach ($layouts as $rule) {

      $layout_rule = maybe_unserialize($rule->selection_rule);

      // First set default.
      if (!empty($layout_rule['default'])) {
        $default = $rule->post_id;
      }

      // Then check to exit.
      if ($rule->export_as_template) {
        continue;
      }

      // Post layout.
      if (!empty($args['post']) && is_a($args['post'], 'WP_Post')) {
        if (!empty($layout_rule['singular']['#all']) || !empty($layout_rule['singular'][$args['post']->post_type])) {
          $layout_id = $rule->post_id;
          return $layout_id;
        }
        continue;
      }

      // Compute selection condition.
      if (!sassy_compute_rule($rule->selection_rule_condition)) {
        continue;
      }

      // TODO singulars are removed from final, think a way to include it,
      // may be with different parameter.
      //
      // Final means, that we should found all content type related layouts.
      if (!empty($args['final'])) {
        if (!empty($layout_rule['archive_entry'])) {
          if (!empty($layout_rule['archive_entry']['post']) && is_home()) {
            $layout_id = $rule->post_id;
            break;
          }
          elseif (!empty($layout_rule['archive_entry']['#all']) || is_post_type_archive(array_keys($layout_rule['archive_entry']))) {
            $layout_id = $rule->post_id;
            break;
          }
        }
      }

      // All other layouts
      else {

        // Generics
        if (!empty($layout_rule['frontpage']) && is_front_page()) {
          $layout_id = $rule->post_id;
        }
        elseif (!empty($layout_rule['login']) && sassy_is_login_page()) {
          $layout_id = $rule->post_id;
        }
        elseif (!empty($layout_rule['404']) && is_404()) {
          $layout_id = $rule->post_id;
        }
        elseif (!empty($layout_rule['singular']) && is_singular()) {
          if (!empty($layout_rule['singular']['#all']) || is_singular(array_keys($layout_rule['singular']))) {
            $layout_id = $rule->post_id;
          }
        }
        elseif (!empty($layout_rule['archive'])) {
          if (!empty($layout_rule['archive']['post']) && is_home()) {
            $layout_id = $rule->post_id;
          }
          // Fix for WooCommerce.
          elseif (!empty($layout_rule['archive']['product']) && get_query_var('wc_query') == 'product_query') {
            $layout_id = $rule->post_id;
          }
          elseif (!empty($layout_rule['archive']['#all']) || is_post_type_archive(array_keys($layout_rule['archive']))) {
            $layout_id = $rule->post_id;
          }
        }

      }

      if ($layout_id) {
        return $layout_id;
      }

    }

    if (!$layout_id && $default && !empty($args['fallback_to_default'])) {
      $layout_id = $default;
    }
  }

  return $layout_id;
}


/**
 * Render layout
 */
function sassy_render_current_page() {
  global $__sassy_main_content, $content_width;

  // If there is no layout plugin.
  if (!has_filter('sassy_layout_render')) {
    echo $__sassy_main_content;
    return;
  }

  $layout_post_id = sassy_get_request_layout_id('fallback_to_default=1');

  if (!$layout_post_id) {
    wp_die(__('5455Y: Page element not found.', 'sassy'), get_bloginfo('name'));
  }

  if (defined('DOING_AJAX')) {
    $ancestors = array($layout_post_id);
  }
  else {
    $ancestors = get_ancestors($layout_post_id, 'sassy-layouts');
    array_unshift($ancestors, $layout_post_id);
  }

  $content_width = '';
  foreach ($ancestors as $ancestor) {

    // Set $content_width global.
    $current_layout_settings = get_post_meta($ancestor, '_sassy_layout_settings', TRUE);
    if (!empty($current_layout_settings['width']['value']) && !empty($current_layout_settings['width']['measurement'])) {
      $content_width = "{$current_layout_settings['width']['value']}{$current_layout_settings['width']['measurement']}";
    }
    if (!empty($current_layout_settings['max_width']['value']) && !empty($current_layout_settings['max_width']['measurement'])) {
      $content_width = "{$current_layout_settings['max_width']['value']}{$current_layout_settings['max_width']['measurement']}";
    }

    // Render current child item to $__sassy_main_content
    $__sassy_main_content = sassy_layout_render($ancestor, FALSE);
  }

  echo $__sassy_main_content;
}


/**
 * Render layout
 *
 * @param $layout_post_id
 * @param bool $echo
 *
 * @return string|NULL
 */
function sassy_layout_render($layout_post_id, $echo = TRUE) {

  $output = apply_filters('sassy_layout_render', '', $layout_post_id);

  if (defined('SASSY_DEBUG') && SASSY_DEBUG) {
    $output = "<!-- layout({$layout_post_id}) -->{$output}<!-- /layout({$layout_post_id}) -->";
  }

  if ($echo) {
    echo $output;
    return NULL;
  }
  else {
    return $output;
  }

}


/**
 * Get exported templates for given post_type
 *
 * @param $post_type
 *
 * @return array
 */
function sassy_layout_get_templates($post_type) {

  static $layouts = NULL;

  if ($layouts === NULL) {
    global $wpdb;

    // If current user is admin, then give high priority to drafts.
    if (current_user_can('customize')) {
      $query_str_post_status = ' IN (\'draft\', \'publish\') ';
      $query_str_order = ' post.menu_order DESC, FIELD(post_status, \'draft\', \'publish\')';
    }
    else {
      $query_str_post_status = ' = \'publish\' ';
      $query_str_order = ' post.menu_order DESC';
    }
    $query = "
      SELECT
        post.ID,
        post.post_title,
        post.post_status,
        selection_rule.meta_value selection_rule,
        export_as_template.meta_value export_as_template
      FROM {$wpdb->posts} post
      INNER JOIN {$wpdb->postmeta} selection_rule
        ON selection_rule.post_id = post.ID
        AND selection_rule.meta_key = '_sassy_layout_selection_rule'
      INNER JOIN {$wpdb->postmeta} export_as_template
        ON export_as_template.post_id = post.ID
        AND export_as_template.meta_key = '_sassy_layout_as_template'
        AND export_as_template.meta_value = '1'
      WHERE
        post.post_type = 'sassy-layouts'
        AND post.post_status {$query_str_post_status}
      ORDER BY {$query_str_order};";

    $layouts = $wpdb->get_results($query);
  }

  $templates = array();

  foreach ($layouts as $layout) {
    $selection_rule = maybe_unserialize($layout->selection_rule);
    if (empty($selection_rule) || !empty($selection_rule['singular']['#all']) || !empty($selection_rule['singular'][$post_type])) {
      $templates[$layout->ID] = $layout->post_title;
      if ($layout->post_status != 'publish') {
        $templates[$layout->ID] .= ' (' . __('Draft', 'sassy') . ')';
      }
    }
  }

  return $templates;
}


/**
 * Compute and validate rules (Sassy condition rule)
 *
 * It could be array for multiples (AND separated) and one (string)
 *
 * Examples computes (work also on singular and nonsingular pages):
 *
 *  post_type=post,page
 *
 *  taxonomy:category
 *  // Check if current post or archive is from taxonomy category
 *  taxonomy:category=cat1,cat2
 *  // Check if current post or archive has taxonomy term cat1 from taxonomy category
 *
 *  get:param1 // Check if current request has $_GET['param1'] set
 *  get:param1=example // Check for $_GET['param1'] = 'example'
 *
 *  post_format=<format1[,...]>
 *
 *  some of the condition tags: 'comments_open', 'pings_open', 'is_home', 'is_front_page',
 * 'is_date', 'is_year', 'is_month', 'is_day', 'is_404', 'is_attachment', 'has_excerpt',
 * 'has_post_thumbnail', 'is_user_logged_in', 'is_rtl', 'in_the_loop', 'is_main_query',
 * 'is_singular', 'is_archive', 'is_search', 'is_paged',
 *
 * Example usage:
 *
 * sassy_compute_rule('post_type=post,news is_singular taxonomy:category=Codes')
 * // Will check if post is singular AND is from type post or news AND is in category Codes
 *
 * sassy_compute_rule('!is_singular');
 * // Every page that is not singular
 *
 * sassy_compute_rule(array(
 *   'is_singular post_type=post taxonomy:category=Codes',
 *   'is_singular post_type=news taxonomy:news_tax=Codes2',
 * ));
 * // Will check if:
 * //   post is singular AND post_type = post AND has category Codes
 * //   OR
 * //   post is singular AND post_type = news AND has category Codes2
 *
 *
 * @param $rules string|array
 *
 * @return bool
 *  TRUE - pass
 *  FALSE - fail
 */
function sassy_compute_rule($rules) {

  global $wp, $wp_query;

  if (is_admin() || !$rules) {
    return TRUE;
  }

  // Check for array of rules.
  if (is_array($rules)) {
    $rules = array_filter($rules);
    foreach ($rules as $rule) {
      if (sassy_compute_rule($rule)) {
        return TRUE;
      }
    }
    return FALSE;
  }

  $rules = strtr($rules, array("\n" => ' ', "\r" => ' '));

  // Handle conditions... OR conditions... OR ... like arrray
  if (strpos($rules, ' OR ')) {
    $multirule = array_filter(explode(' OR ', $rules));
    return sassy_compute_rule($multirule);
  }

  $cururl = $wp->query_string;

  $rules = preg_split('#[\s\&]+#', $rules, -1, PREG_SPLIT_NO_EMPTY);
  foreach ($rules as $rule) {

    $rule = explode('=', $rule, 2);
    $name = $rule[0];
    $has_arg = isset($rule[1]);
    $args = $has_arg ? array_map('trim', explode(',', $rule[1])) : array();
    if ($name{0} == '!') {
      $negate = TRUE;
      $name = substr($name, 1);
    }
    else {
      $negate = FALSE;
    }

    $state = TRUE;

    // URL checking
    if ($name == 'url') {
      $urlmatch = 0;
      foreach ($args as $arg) {
        if (fnmatch($arg, $cururl)) {
          $urlmatch++;
          break;
        }
      }
      if (!$urlmatch) {
        $state = FALSE;
      }
    }

    // Post type check
    elseif ($name == 'post_type') {
      if (is_singular()) {
        if (!is_singular($args)) {
          $state = FALSE;
        }
      }
      else {
        if (!is_post_type_archive($args)) {
          $state = FALSE;
        }
      }
    }

    // Post format
    elseif ($name == 'post_format') {
      if (!in_array(get_post_format(), $args)) {
        $state = FALSE;
      }
    }

    // Taxonomy.
    elseif (preg_match('#^taxonomy\:([^\s]+)#i', $name, $matches)) {
      if (is_singular()) {
        if ($has_arg) {
          if (!has_term($args, $matches[1])) {
            $state = FALSE;
          }
        }
      }
      else {
        if ($has_arg) {
          if (!is_tax($matches[1], $args)) {
            $state = FALSE;
          }
        }
        else {
          if (!is_tax($matches[1])) {
            $state = FALSE;
          }
        }
      }
    }

    // GET request checks
    elseif (preg_match('#^get\:([^\s]+)#i', $name, $matches)) {
      if (!isset($_GET[$matches[1]])) {
        $state = FALSE;
      }
      if ($has_arg) {
        if (!in_array($_GET[$matches[1]], $args)) {
          $state = FALSE;
        }
      }
    }

    // Even/Odd
    elseif ($name == 'is_even') {
      $state = !($wp_query->current_post%2);
    }
    elseif ($name == 'is_odd') {
      $state = $wp_query->current_post%2;
    }

    // Check for conditions tags that shouldn't accept args
    elseif (in_array($name, array(
      'comments_open',
      'pings_open',
      'is_home',
      'is_front_page',
      'is_date',
      'is_year',
      'is_month',
      'is_day',
      'is_404',
      'is_attachment',
      'has_excerpt',
      'has_post_thumbnail',
      'is_multi_author',
      'is_user_logged_in',
      'is_rtl',
      'in_the_loop',
      'is_main_query',
      'is_paged',
      'is_search',
      'is_archive',
      'wp_attachment_is_image',
    ))) {
      $state = call_user_func($name);
    }

    // Check for conditions tags that accept args
    elseif (in_array($name, array(
      'is_singular',
      'is_post_type_archive',
      'is_author',
    ))) {
      $state = call_user_func($name, $args);
    }

    // If current page is login page.
    elseif ($name == 'is_login_page') {
      $state = sassy_is_login_page();
    }

    // Unknown condition.
    else {
      $state = FALSE;
    }

    // Allow others to interact with the compute rule.
    $state = apply_filters('sassy_compute_rule_tag', $state, $name, $args);

    if ($negate) {
      $state = !$state;
    }

    if (!$state) {
      return FALSE;
    }

  }

  return TRUE;
}


/**
 * Class SassyLayout
 */
class SassyLayouts {

  function __construct() {
    if (defined('SASSY_NOLAYOUTING_PLUGIN')) {
      return;
    }

    add_action('after_setup_theme', array($this, 'setup'));
  }

  /**
   * Setup layouts
   */
  function setup() {
    $args = array(
      'label'                => __('Layouts', 'sassy'),
      'description'          => __('Site Layouts', 'sassy'),
      'labels'               => array(
        'name'               => __('Layouts', 'sassy'),
        'singular_name'      => __('Layout', 'sassy'),
        'menu_name'          => __('Site layouts', 'sassy'),
        'parent_item_colon'  => __('Parent layout', 'sassy'),
        'all_items'          => __('Layouts', 'sassy'),
        'view_item'          => __('View layout', 'sassy'),
        'add_new_item'       => __('Create layout', 'sassy'),
        'add_new'            => __('Design new layout', 'sassy'),
        'edit_item'          => __('Edit layout', 'sassy'),
        'update_item'        => __('Update', 'sassy'),
        'search_items'       => __('Search', 'sassy'),
        'not_found'          => __('No found', 'sassy'),
        'not_found_in_trash' => __('Not found in Trash', 'sassy'),
      ),
      'supports'             => array('title'),
      'hierarchical'         => TRUE,
      'public'               => FALSE,
      'show_ui'              => TRUE,
      'show_in_menu'         => (current_user_can('customize') ? 'themes.php' : FALSE),
      'menu_position'        => 1000,
      'show_in_nav_menus'    => TRUE,
      'show_in_admin_bar'    => FALSE,
      'menu_icon'            => 'dashicons-schedule',
      'register_meta_box_cb' => array($this, 'register_metaboxes'),
      'can_export'           => FALSE,
      'has_archive'          => FALSE,
      'exclude_from_search'  => TRUE,
      'publicly_queryable'   => FALSE,
      'rewrite'              => FALSE,
      'cap' => array(
        'edit_post'              => 'customize',
        'read_post'              => 'customize',
        'delete_post'            => 'customize',
        'edit_posts'             => 'customize',
        'edit_others_posts'      => 'customize',
        'publish_posts'          => 'customize',
        'read_private_posts'     => 'customize',
        'read'                   => 'customize',
        'delete_posts'           => 'customize',
        'delete_private_posts'   => 'customize',
        'delete_published_posts' => 'customize',
        'delete_others_posts'    => 'customize',
        'edit_private_posts'     => 'customize',
        'edit_published_posts'   => 'customize',
        'create_posts'           => 'customize',
      )
    );

    call_user_func('register_post_type', 'sassy-layouts', $args);

    add_action('admin_bar_menu', array($this, 'admin_bar_menu'), SASSY_HOOK_LAST_PNUM);
    add_action('admin_notices', array($this, 'notice_no_layouts'));

    add_filter('pre_get_posts', array($this, 'pre_get_posts'));
    add_filter('edit_posts_per_page', array($this, 'edit_posts_per_page'), 10, 2);
    add_filter('post_type_link', array($this, 'post_type_link') , 5, 4);
    add_filter('template_include', array($this, 'template_include'), SASSY_HOOK_LAST_PNUM);
    add_filter('sassy_js_settings', array($this, 'sassy_js_settings'));

    add_action('save_post_sassy-layouts', array($this, 'save_post_sassy_layouts'), 10, 3);
    add_action('post_submitbox_misc_actions', array($this, 'post_submitbox_misc_actions'), SASSY_HOOK_LAST_PNUM);
    add_action('save_post', array($this, 'save_post'));

    add_action('manage_sassy-layouts_posts_custom_column', array($this, 'manage_sassy_layouts_post_custom_column'), 10, 2);
    add_filter('manage_edit-sassy-layouts_columns', array($this, 'manage_edit_sassy_layouts_columns'));
    add_filter('manage_edit-sassy-layouts_sortable_columns', '__return_empty_array');
    add_filter('bulk_actions-sassy-layouts', '__return_empty_array');
    add_filter('bulk_actions-edit-sassy-layouts', '__return_empty_array');
    add_filter('page_row_actions', array($this, 'page_row_actions') , 10, 2);

    // Add login screen supports
    add_action('login_init', array($this, 'login_init'));
    add_action('login_footer', array($this, 'login_footer'));

  }


  /**
   * Add layout templates in publishbox
   */
  function post_submitbox_misc_actions() {
    global $post;

    // No need to display layout selector for some system post types.
    $disabled_post_types = apply_filters('sassy_layouts_disabled_post_types', array(
      'acf', 'ml-slider', 'wysijap'
    ));

    if (in_array($post->post_type, $disabled_post_types)) {
      return;
    }

    // Check if there is a templates then add them.
    $templates = sassy_layout_get_templates($post->post_type);
    if ($templates) {
      $_sassy_use_template = get_post_meta($post->ID, '_sassy_use_template', TRUE);
      echo '
      <div class="misc-pub-section misc-pub-sassy-layout">
        <label>
          ' . __('Use layout', 'sassy') . ':
          <select name="_sassy_use_template">
            <option value=""> - ' . __('None', 'sassy') . ' - </option>';
      foreach ($templates as $template_post_id => $template_title) {
        echo '<option value="' . esc_attr($template_post_id) . '" ' . selected($template_post_id, $_sassy_use_template, FALSE) . '>' . esc_html($template_title) . '</option>';
      }
      echo '
          </select>
        </label>
      </div>';
    }

  }


  /**
   * No layouts suggestions
   */
  function notice_no_layouts() {
    $posts = wp_count_posts('sassy-layouts');
    if ($posts && $posts->publish > 1) {
      return;
    }
    $url_auto = admin_url('themes.php?page=sassy-system');
    $url_manual = admin_url('edit.php?post_type=sassy-layouts');
    ?>
    <div class="notice notice-warning">
      <p>
        <?php printf(__('Seems that you have no defined any layouts. <a href="%s">Do you want to install base set of layouts</a> or <a href="%s">you might want to create manual by yourself</a>.', 'sassy'), $url_auto, $url_manual)?>
      </p>
    </div>
    <?php
  }


  /**
   * Layouts post_save stuff
   *
   * @param $post_id
   */
  function save_post($post_id) {

    // If this is just a revision, don't send the email.
    if (wp_is_post_revision($post_id)) {
      return;
    }

    // If there is sasy template in posts then save it.
    if (isset($_REQUEST['_sassy_use_template']) && is_numeric($_REQUEST['_sassy_use_template'])) {
      update_post_meta($post_id, '_sassy_use_template', $_REQUEST['_sassy_use_template']);
    }
  }


  /**
   * Alter main template
   *
   * TODO found way to clear out this logic
   *
   * @param string $template
   *
   * @return string
   */
  function template_include($template) {

    // If we found some of the finals, then for more by performance causes
    // will be better to not load default template then pass to sassy's one,
    // but directly to load the index.
    // Examples: WooCommerce singles
    if (sassy_get_request_layout_id('final=1&fallback_to_default=0')) {
      // But then we could break "Context Placeholder" widget :(
      // $template = locate_template('index.php');
    }

    return $template;
  }


  /**
   * Add js settings
   */
  function sassy_js_settings($settings) {

    $settings['mobile_behavior_breakpoint'] = 0;
    $root_layout = sassy_get_root_layout_id();
    if ($root_layout) {
      $layout_settings = get_post_meta($root_layout, '_sassy_layout_settings', TRUE);
      $settings['mobile_behavior_breakpoint'] = empty($layout_settings['mobile_behavior_breakpoint']) ? 0 : $layout_settings['mobile_behavior_breakpoint'];
    }

    $settings['mqs'] = array_filter(array_keys(sassy_available_breakpoints()));

    return $settings;

  }


  /**
   * Override the link
   */
  function post_type_link($post_link, $post, $leavename, $sample) {
    if ($post->post_type == 'sassy-layouts') {
      $post_link = get_edit_post_link($post->ID);
    }
    return $post_link;
  }


  /**
   * Remove row actions
   */
  function page_row_actions($actions, $post) {
    if ($post->post_type == 'sassy-layouts') {
      $whitelist = array('untrash' => 1, 'delete' => 1);
      return array_intersect_key($actions, $whitelist);
    }
    return $actions;
  }


  /**
   * Override post per page for layouts admin.
   */
  function edit_posts_per_page($per_page, $post_type) {
    if ($post_type == 'sassy-layouts') {
      return 100;
    }
    return $per_page;
  }


  /**
   * @list
   * Override columns
   */
  function manage_edit_sassy_layouts_columns($columns) {
    return array(
      'menu_order' => __('Priority', 'sassy'),
      'type' => __('Type', 'sassy'),
      'title' => __('Name', 'sassy'),
      'selection_rule' => __('Selection rule', 'sassy'),
    );
  }


  /**
   * @list
   * Add task edit list columns.
   */
  function manage_sassy_layouts_post_custom_column($column_name, $post_id) {
    global $post;
    if ($column_name == 'menu_order') {
      echo $post->menu_order;
    }
    elseif ($column_name == 'type') {
      $type = get_post_meta($post_id, '_sassy_layout_type', TRUE);
      if ($type == 'menu') {
        echo '<span class="dashicons dashicons-editor-ul"></span> ';
        echo __('Sub-menu', 'sassy');
      }
      else {
        echo '<span class="dashicons dashicons-welcome-widgets-menus"></span> ';
        echo __('Pages', 'sassy');
      }
    }
    elseif ($column_name == 'selection_rule') {
      $selection_rule = get_post_meta($post_id, '_sassy_layout_selection_rule', TRUE);
      if ($selection_rule) {
        $rule_text = array();
        if (!empty($selection_rule['default'])) {
          $rule_text[] = '<strong>' . __('Default', 'sassy') . '</strong>';
        }
        if (!empty($selection_rule['frontpage'])) {
          $rule_text[] = __('Frontpage', 'sassy');
        }
        if (!empty($selection_rule['404'])) {
          $rule_text[] = __('Error 404', 'sassy');
        }
        if (!empty($selection_rule['login'])) {
          $rule_text[] = __('Login', 'sassy');
        }
        if (!empty($selection_rule['singular'])) {
          if (!empty($selection_rule['singular']['#all'])) {
            $rule_text[] = sprintf(__('All %s', 'sassy'), __('Single', 'sassy'));
          }
          else {
            $rule_text[] = sprintf(__('Single: %s', 'sassy'), implode(', ', array_keys($selection_rule['singular'])));
          }
        }
        if (!empty($selection_rule['archive_entry'])) {
          if (!empty($selection_rule['archive_entry']['#all'])) {
            $rule_text[] = sprintf(__('All %s', 'sassy'), __('Archive', 'sassy'));
          }
          else {
            $rule_text[] = sprintf(__('Archive Entry: %s', 'sassy'), implode(', ', array_keys($selection_rule['archive_entry'])));
          }
        }
        if (!empty($selection_rule['archive'])) {
          if (!empty($selection_rule['archive']['#all'])) {
            $rule_text[] = sprintf(__('All %s', 'sassy'), __('Archive', 'sassy'));
          }
          else {
            $rule_text[] = sprintf(__('Archive: %s', 'sassy'), implode(', ', array_keys($selection_rule['archive'])));
          }
        }

        echo '<ul>';
        foreach ($rule_text as $rule_text_label) {
          echo '<li>' . $rule_text_label . '</li>';
        }
        echo '</ul>';
      }
      else {
        echo '<em> ' . __('Not used', 'sassy') . '</em>';
      }

    }
  }


  /**
   * Override the admin view
   */
  function pre_get_posts($query) {
    if (is_admin() && $query->get('post_type') == 'sassy-layouts' && !is_customize_preview()) {

      if (get_current_screen()->base == 'nav-menus') {
        $query->set('meta_key', '_sassy_layout_type');
        $query->set('meta_value', 'menu');
      }

      elseif ($query->is_main_query()) {
        $query->set('order', 'desc');
        $query->set('orderby', 'menu_order');
      }

    }
  }


  /**
   * Remove metaboxes.
   */
  function register_metaboxes($post) {
    add_meta_box('sassy-layouts-layout-settings', __('Layout settings', 'sassy'), array($this,'layout_settings_metabox'), 'sassy-layouts', 'advanced', 'high');
    add_meta_box('sassy-layouts-attributes', __('Attributes', 'sassy'), array($this,'attributes_metabox'), 'sassy-layouts', 'side', 'high');
    remove_meta_box('submitdiv', 'sassy-layouts', 'side');
    remove_meta_box('postcustom', 'sassy-layouts', 'normal');
    remove_meta_box('slugdiv', 'sassy-layouts', 'normal');
    remove_meta_box('authordiv', 'sassy-layouts', 'normal');
    remove_meta_box('commentstatusdiv', 'sassy-layouts', 'normal');
    remove_meta_box('trackbacksdiv', 'sassy-layouts', 'normal');
  }

  /**
   * Layout settings metabox
   *
   * @param $post
   */
  function layout_settings_metabox($post) {

    $available_breakpoints = sassy_available_breakpoints();

    $_sassy_layout_settings = get_post_meta($post->ID, '_sassy_layout_settings', TRUE);
    if (!is_array($_sassy_layout_settings)) {
      $_sassy_layout_settings = array();
    }

    // Reset initial array of settings.
    $_sassy_layout_settings = array_merge(array(
      'box' => FALSE,
      'masonry' => FALSE,
      'mobile_behavior_breakpoint' => '',
      'breakpoint' => array(),
      'width' => array(),
      'width_measurement' => array(),
      'max_width' => array(),
      'max_width_measurement' => array(),
      'vertical_margin' => array(),
      'horizontal_margin' => array(),
    ), $_sassy_layout_settings);
    // Populate array with dummy element in case it not exists or something is happen.
    if (empty($_sassy_layout_settings['breakpoint']) || !is_array($_sassy_layout_settings['breakpoint'])) {
      $_sassy_layout_settings['breakpoint'] = array(
        0 => '',
      );
    }

    // Sort breakpoints so No-breakpoint will be always on top,
    // but rest will be in reversed order.
    arsort($_sassy_layout_settings['breakpoint'], SORT_NUMERIC);
    uasort($_sassy_layout_settings['breakpoint'], function($a, $b) {
      return !$a ? -1 : 1;
    });


    ?>
    <div class="sassy-layout-disable-for-type-menu">
      <p>
        <label for="sassy-layout-settings-field-box">
          <input type="checkbox" id="sassy-layout-settings-field-box" name="sassy_layout_settings[box]" value="1" <?php checked(TRUE, $_sassy_layout_settings['box'])?>" />
          <?php _e('Box layout', 'sassy')?>
        </label>
      </p>
      <p class="sassy-layout-settings-field-masonry">
        <label for="sassy-layout-settings-field-masonry">
          <input type="checkbox" id="sassy-layout-settings-field-masonry" name="sassy_layout_settings[masonry]" value="1" <?php checked(TRUE, $_sassy_layout_settings['masonry'])?>" />
          <?php _e('Cascading grid layout (masonry)', 'sassy')?>
        </label>
      </p>
    </div>

    <div class="sassy-layout-breakpoints-settings">

      <?php foreach ($_sassy_layout_settings['breakpoint'] as $key => $breakpoint):?>
      <div class="sassy-layout-settings-field-box-wrapper-dimensions">
        <p>
          <label class="no-break breakpoint-width">
            <?php _e('Breakpoint width', 'sassy')?>
            <select name="sassy_layout_settings[breakpoint][]">
              <?php foreach ($available_breakpoints as $width => $label):?>
                <option value="<?php echo $width?>" <?php selected($width, $breakpoint)?>>
                  <?php echo esc_html($label)?>
                </option>
              <?php endforeach?>
            </select>
          </label>
          <button type="button" class="button sassy-layout-settings-dimensions-breakpoint-remove">
            <?php _e('Remove', 'sassy')?>
          </button>
        </p>
        <p class="sassy-layout-settings-field-box-wrapper-width">
          <label class="no-break">
            <?php _e('Width', 'sassy')?>
            <input type="number" name="sassy_layout_settings[width][]" value="<?php echo esc_attr(empty($_sassy_layout_settings['width'][$key]) ? '' : $_sassy_layout_settings['width'][$key])?>" size="6" min="1" style="width:6em;" />
            <?php sassy_measurement_selector('sassy_layout_settings[width_measurement][]', empty($_sassy_layout_settings['width_measurement'][$key]) ? '' : $_sassy_layout_settings['width_measurement'][$key])?>
          </label>
          &nbsp;
          <label class="no-break">
            <?php _e('Max width', 'sassy')?>
            <input type="number" name="sassy_layout_settings[max_width][]" value="<?php echo esc_attr(empty($_sassy_layout_settings['max_width'][$key]) ? '' : $_sassy_layout_settings['max_width'][$key])?>" size="6" min="1" style="width:6em;" />
            <?php sassy_measurement_selector('sassy_layout_settings[max_width_measurement][]', empty($_sassy_layout_settings['max_width_measurement'][$key]) ? '' : $_sassy_layout_settings['max_width_measurement'][$key])?>
          </label>
        </p>
        <p class="sassy-layout-settings-field-box-wrapper-margins">
          <label class="no-break">
            <?php _e('Horizontal margin', 'sassy')?>
            <input type="number" name="sassy_layout_settings[horizontal_margin][]" value="<?php echo esc_attr(empty($_sassy_layout_settings['horizontal_margin'][$key]) ? '' : $_sassy_layout_settings['horizontal_margin'][$key])?>" size="6" min="1" style="width:6em;" />
            <?php sassy_measurement_selector('sassy_layout_settings[horizontal_margin_measurement][]', empty($_sassy_layout_settings['horizontal_margin_measurement'][$key]) ? '' : $_sassy_layout_settings['horizontal_margin_measurement'][$key])?>
          </label>
          &nbsp;
          <label class="no-break">
            <?php _e('Vertical margin', 'sassy')?>
            <input type="number" name="sassy_layout_settings[vertical_margin][]" value="<?php echo esc_attr(empty($_sassy_layout_settings['vertical_margin'][$key]) ? '' : $_sassy_layout_settings['vertical_margin'][$key])?>" size="6" min="1" style="width:6em;" />
            <?php sassy_measurement_selector('sassy_layout_settings[vertical_margin_measurement][]', empty($_sassy_layout_settings['vertical_margin_measurement'][$key]) ? '' : $_sassy_layout_settings['vertical_margin_measurement'][$key])?>
          </label>
        </p>

      </div>
      <?php endforeach?>

    </div>

    <p>
      <button type="button" class="button" id="sassy-layout-settings-dimensions-breakpoint-add"><?php _e('Add breakpoint', 'sassy')?></button>
    </p>

    <p class="sassy-layout-disable-for-type-menu sassy-layouts-breakpoints-mobile-behavior">
      <label class="no-break breakpoint-width">
        <?php _e('Mobile behavior breakpoint', 'sassy')?>
        <select name="sassy_layout_settings[mobile_behavior_breakpoint]">
          <?php foreach ($available_breakpoints as $width => $label):?>
            <option value="<?php echo $width?>" <?php selected($width, $_sassy_layout_settings['mobile_behavior_breakpoint'])?>>
              <?php echo esc_html($label)?>
            </option>
          <?php endforeach?>
        </select>
      </label>
    </p>


    <script>
      (function($) {
        $(document).ready(function() {

          $('.sassy-layout-settings-dimensions-breakpoint-remove')
            .on('click', function(event) {
              if ($('.sassy-layout-settings-field-box-wrapper-dimensions').length > 1) {
                $(this).closest('.sassy-layout-settings-field-box-wrapper-dimensions').remove();
              }
            });

          $('#sassy-layout-settings-dimensions-breakpoint-add')
            .on('click', function(event) {
              var lastEl = $('.sassy-layout-settings-field-box-wrapper-dimensions').last();
              var newEl = $(lastEl).clone(true);
              $(newEl)
                .removeClass('sassy-layout-settings-field-box-wrapper-dimensions-default')
                .addClass('sassy-layout-settings-field-box-wrapper-dimensions-breakpoint')
              $(newEl).insertAfter(lastEl);
              $('input, select[name="sassy_layout_settings[breakpoint][]"]', newEl).val('');
            });

        });

        /**
         * Hide these items for now, until found way how to use them propertly.
         */
        $(document)
          .on('panels_setup', function(builderView) {
            $('.so-builder-toolbar .so-live-editor,.so-builder-toolbar .so-history')
              .hide();
          });


      }(jQuery));
    </script>

    <?php
  }


  /**
   * Add custom meta box.
   */
  function attributes_metabox($post) {
    global $action;

    $hierarchical_layouts_qargs = array(
      'post_type' => 'sassy-layouts',
      'post_status' => 'publish',
      'exclude_tree' => $post->ID,
      'selected' => $post->post_parent,
      'name' => 'parent_id',
      'show_option_none' => ' - ' . __('Global layout', 'sassy') . ' - ',
      'sort_column' => 'menu_order, post_title',
      'meta_key' => '_sassy_layout_type',
      'meta_value' => 'site',
      'echo' => 0,
    );
    $has_children = (bool) get_pages(array('child_of' => $post->ID, 'post_type' => 'sassy-layouts', 'numberposts' => 1));
    $labels = get_post_type_object('sassy-layouts')->labels;

    $sassy_layout_selection_rule = get_post_meta($post->ID, '_sassy_layout_selection_rule', TRUE);
    $sassy_layout_selection_rule_condition = get_post_meta($post->ID, '_sassy_layout_selection_rule_condition', TRUE);
    $sassy_layouts_type = get_post_meta($post->ID, '_sassy_layout_type', TRUE);
    $sassy_layout_as_settings = get_post_meta($post->ID, '_sassy_layout_as_template', TRUE);

    // Add an nonce field so we can check for it later.
    wp_nonce_field('sassy_layouts_attributes', 'sassy_layouts_attributes_nonce' );

    $layout_type_disabled_attr = '';
    ?>

    <p>
      <strong><?php _e('Layout type:', 'sassy')?> </strong>
      <?php if ($post->post_parent || $has_children):?>
        <input type="hidden" name="sassy_type" value="<?php echo esc_attr($sassy_layouts_type)?>" />
        <?php $layout_type_disabled_attr = ' disabled="disabled"'; ?>
      <?php endif?>
      <select name="sassy_type" id="sassy-layouts-type" <?php echo $layout_type_disabled_attr?>>
        <option value="site"><?php _e('Pages', 'sassy')?></option>
        <?php
        // Seems as a good idea but actually it duplicate sitepanel origin main idea :D
        // <option value="template" <?php selected('template', $sassy_layouts_type)?>><?php _e('Template', 'sassy')?></option>
        ?>
        <option value="menu" <?php selected('menu', $sassy_layouts_type)?>><?php _e('Sub-menu', 'sassy')?></option>
      </select>
    </p>

    <?php if ('' !== ($hierarchical_layouts = wp_dropdown_pages($hierarchical_layouts_qargs))):?>
      <p class="sassy-layout-disable-for-type-menu">
        <strong><?php _e('Sub-layout of:', 'sassy')?> </strong>
        <label for="parent_id" class="screen-reader-text"><?php _e('Sub-layout of', 'sassy')?></label>
        <?php echo $hierarchical_layouts?>
      </p>
    <?php endif?>

    <p class="sassy-layout-disable-for-type-menu">
      <label>
        <input type="checkbox" name="sassy_layout_as_template" value="1" <?php checked(TRUE, $sassy_layout_as_settings)?>" />
        <?php _e('Export as post template', 'sassy')?>
      </label>
    </p>

    <?php
    echo '
    <div class="sassy-layout-disable-for-type-menu">
      <div>
        <strong>' . __('Selection rule page type:', 'sassy') . '</strong>
      </div>
      <div class="sassy-layouts-selection-rule">
        <ul>
          <li>
            <label>
              <input ' . checked(TRUE, !empty($sassy_layout_selection_rule['default']), FALSE) . ' type="checkbox" name="sassy_selection_rule[default]" />
              <em> - ' . __('Default', 'sassy') . ' - </em>
            </label>
          </li>
          <li>
            <label>
              <input ' . checked(TRUE, !empty($sassy_layout_selection_rule['frontpage']), FALSE) . ' type="checkbox" name="sassy_selection_rule[frontpage]" />
              ' . __('Frontpage', 'sassy') . '
            </label>
          </li>
          <li>
            <label>
              <input ' . checked(TRUE, !empty($sassy_layout_selection_rule['login']), FALSE) . ' type="checkbox" name="sassy_selection_rule[login]" />
              ' . __('Login', 'sassy') . '
            </label>
          </li>
          <li>
            <label>
              <input ' . checked(TRUE, !empty($sassy_layout_selection_rule['404']), FALSE) . ' type="checkbox" name="sassy_selection_rule[404]" />
              ' . __('Error 404', 'sassy') . '
            </label>
          </li>';

      // Single/Archives
      $post_types = get_post_types(array('public' => TRUE), 'object');
      $post_types_rules = array(
        'singular' => __('Single', 'sassy'),
        'archive' => __('Archive', 'sassy'),
        'archive_entry' => __('Archive Entry', 'sassy'),
      );

      $skip_post_types = array(
        'attachment' => array('archive', 'archive_entry'),
      );
      if (!SassySettings::get('post_types_attachments_visits')) {
        $skip_post_types['attachment'][] = 'singular';
      }

      $skip_post_types = apply_filters('sassy_layout_selection_rule_skip_types', $skip_post_types);

      foreach ($post_types_rules as $key => $label) {
        echo '
            <li>
              <label>
                <input ' . checked(TRUE, !empty($sassy_layout_selection_rule[$key]['#all']), FALSE) . ' type="checkbox" name="sassy_selection_rule[' . $key . '][#all]" />
                 ' . sprintf(__('%s (default)', 'sassy'), $label) . '
              </label>
            </li>
            <li>
            <ul class="inline">';
        foreach ($post_types as $post_type) {

          // Skipped items.
          if (!empty($skip_post_types[$post_type->name]) && in_array($key, $skip_post_types[$post_type->name])) {
            continue;
          }

          echo '
              <li>
                <label>
                  <input ' . checked(TRUE, !empty($sassy_layout_selection_rule[$key][$post_type->name]), FALSE) . ' type="checkbox" name="sassy_selection_rule[' . $key . '][' . $post_type->name . ']" />
                  ' . $post_type->label . '
                </label>
              </li>';
        }
        echo '
            </ul>
          </li>';
      }
      echo '
        </ul>
      </div>
    </div>';

    ?>
    <details class="sassy-selection-rule-condition sassy-layout-disable-for-type-menu" <?php echo ($sassy_layout_selection_rule_condition ? 'open' : '' )?>>
      <summary><?php esc_attr_e('Selection rule condition', 'sassy')?></summary>
      <textarea name="sassy_selection_rule_condition" placeholder="<?php esc_attr_e('Sassy condition rule', 'sassy')?>"><?php echo esc_html($sassy_layout_selection_rule_condition)?></textarea>
    </details>

    <hr />

    <input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr(('auto-draft' == $post->post_status) ? 'draft' : $post->post_status)?>" />
    <input type="hidden" name="visibility" value="public" />
    <input name="original_publish" type="hidden" id="original_publish" value="<?php echo esc_attr($post->post_status)?>" />

    <p class="sassy-layout-disable-for-type-menu">
      <strong><?php _e('Priority:', 'sassy')?> </strong>
      <label for="selection-rule-priority" class="screen-reader-text"><?php _e('Priority', 'sassy')?></label>
      <input type="number" id="selection-rule-priority" name="menu_order" value="<?php echo esc_attr($post->menu_order)?>" style="width:5em;" size="3" min="-9999" max="9999" step="1" />
    </p>

    <p>
      <strong>
        <?php _e('Status', 'sassy')?>
      </strong>
      <select name="post_status">
        <option value="publish"><?php _e('Published', 'sassy')?></option>
        <option value="draft" <?php selected('draft', $post->post_status)?>><?php _e('Draft', 'sassy')?></option>
      </select>
    </p>

    <?php if ($post->post_status != 'publish'):?>
    <p class="description">
      <?php _e('Draft status is visible only by admins, it could be used for a testing and in development purposes. All non-admin users will skip draft layouts.', 'sassy')?>
    </p>
    <?php endif?>

    <div class="submitbox" id="submitpost">
      <p>
        <?php submit_button(($action == 'edit' ? $labels->update_item : $labels->add_new_item), 'primary', 'save', FALSE)?>
      </p>
      <?php if (!$has_children):?>
        <?php if ($post && $action == 'edit'):?>
          <p>
            <a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID)?>">
              <?php _e('Move to Trash', 'sassy')?>
            </a>
          </p>
        <?php endif?>
      <?php else:?>
        <p>
          <strong>
            <em>
              <?php _e('This layout have childrens and could not be moved to trash.', 'sassy')?>
            </em>
          </strong>
        </p>
      <?php endif?>
    </div>
    <script>
      (function($) {
        $(document).ready(function() {

          // Show mobile behavior breakpoint only when have no parents.
          $('#parent_id')
            .on('change', function() {
              if ($(this).val() == '') {
                $('.sassy-layouts-breakpoints-mobile-behavior').slideDown(100);
              }
              else {
                $('.sassy-layouts-breakpoints-mobile-behavior').slideUp(100);
              }
            })
            .trigger('change');

          // Depend of layout type show/hide some elements.
          $('#sassy-layouts-type')
            .on('change', function() {
              if ($(this).val() == 'menu') {
                $('.sassy-layout-disable-for-type-menu').slideUp(100);
              }
              else {
                $('.sassy-layout-disable-for-type-menu').slideDown(100);
              }
            })
            .trigger('change');

          // Show masonry selector only when archives
          var sassyLayoutSettingsFieldMasonry = function() {
            if ($(':input[name*="sassy_selection_rule\[archive\]"]:checked').length > 0) {
              $('.sassy-layout-settings-field-masonry').slideDown(100);
            }
            else {
              $('.sassy-layout-settings-field-masonry').slideUp(100);
            }
          };
          $('.sassy-layouts-selection-rule :input')
            .on('change', sassyLayoutSettingsFieldMasonry);
          sassyLayoutSettingsFieldMasonry();

        });
      }(jQuery));
    </script>
  <?php
  }


  /**
   * Save layout
   */
  function save_post_sassy_layouts($post_id, $post, $update) {

    // We should do the save only when really need it.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }
    if (empty($post_id) || empty($post) || empty($_POST['post_type']) || $post->post_type !== 'sassy-layouts') {
      return;
    }
    if (isset($_POST['_inline_edit']) && !wp_verify_nonce($_POST[ '_inline_edit' ], 'inlineeditnonce')) {
      return;
    }
    if (empty($_POST['sassy_layouts_attributes_nonce']) || !wp_verify_nonce($_POST['sassy_layouts_attributes_nonce'], 'sassy_layouts_attributes')) {
      return;
    }
    // Finally, check if user have access.
    if (!current_user_can('customize', $post_id)) {
      return;
    }


    // Selection rule.
    $data = filter_input(INPUT_POST, 'sassy_selection_rule', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    update_post_meta($post_id, '_sassy_layout_selection_rule', $data ? $data : array());

    // Selection rule condition.
    update_post_meta($post_id, '_sassy_layout_selection_rule_condition', strval(filter_input(INPUT_POST, 'sassy_selection_rule_condition', FILTER_SANITIZE_STRING)));

    // Type.
    update_post_meta($post_id, '_sassy_layout_type', strval(filter_input(INPUT_POST, 'sassy_type', FILTER_SANITIZE_STRING)));

    // Export as template.
    update_post_meta($post_id, '_sassy_layout_as_template', strval(filter_input(INPUT_POST, 'sassy_layout_as_template', FILTER_SANITIZE_STRING)));

    // Layout settings.
    $data = filter_input(INPUT_POST, 'sassy_layout_settings', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    update_post_meta($post_id, '_sassy_layout_settings', $data ? $data : array());

  }


  /**
   * Add admin bar menu for sassy layouts
   */
  function admin_bar_menu($admin_bar){

    // At this time we need such menu only for frontend,
    // may be in future some users will need something new.
    if (!is_admin() && current_user_can('customize')) {

      $admin_bar->add_menu( array(
        'id'    => 'sassy-layouts',
        'title' => __('Layouts', 'sassy'),
        'href'  => admin_url('edit.php?post_type=sassy-layouts'),
      ));

      $root_layout_id = sassy_get_root_layout_id();
      $current_layout_id = sassy_get_request_layout_id('final=1');
      if ($root_layout_id || $current_layout_id) {
        if ($current_layout_id) {
          $layout_trail = array_reverse(get_post_ancestors($current_layout_id));
          $layout_trail[] = $current_layout_id;
        }
        else {
          $layout_trail = array($root_layout_id);
        }

        foreach (array_unique($layout_trail) as $k => $layout_post) {
          $post = get_post($layout_post);
          $deep_d = $k ? str_repeat('&mdash;', $k) . ' ' : '';
          $admin_bar->add_menu(array(
            'id'     => 'sassy-layout-current-' . $post->ID,
            'parent' => 'sassy-layouts',
            'title'  => $deep_d . ($post->post_title ? $post->post_title : sprintf(__('Unnamed %s', 'sassy'), $post->ID)),
            'href'   => get_edit_post_link($post->ID),
          ));
        }
      }

    }
  }


  /**
   * Start getting the logins header
   */
  function login_init() {

    if (defined('SASSY_DISABLE_LOGIN_LAYOUT') && SASSY_DISABLE_LOGIN_LAYOUT) {
      return;
    }

    $interim_login = isset($_REQUEST['interim-login']);

    if ($interim_login) {
      return;
    }

    global $sassy_login_layout_id;
    $sassy_login_layout_id = sassy_get_request_layout_id('fallback_to_default=0');
    if ($sassy_login_layout_id) {
      ob_start();
    }
  }


  /**
   * Login footer, where we should output our template
   */
  function login_footer() {

    if (defined('SASSY_DISABLE_LOGIN_LAYOUT') && SASSY_DISABLE_LOGIN_LAYOUT) {
      return;
    }

    $interim_login = isset($_REQUEST['interim-login']);
    global $sassy_login_layout_id;

    if ($interim_login || empty($sassy_login_layout_id)) {
      return;
    }

    $output = ob_get_clean();
    if (preg_match("/<body[^>]*>(.*?)<\\/body>/is", $output . '</body>', $matches)) {
      $output = $matches[1];
    }

    get_header();

    echo $output;

    get_footer();

    exit;
  }

}


// Init layout system.
return new SassyLayouts();
