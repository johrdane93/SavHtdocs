<?php

define('SASSY_VERSION', '0.99');
define('SASSY_HOOK_LAST_PNUM', 65536);


/**
 * Check for PHP version
 */
if (version_compare(phpversion(), '5.3.0', '<')) {

  /**
   * Backend message.
   */
  function _sassy_notices_php() {
    echo '<div class="error"><p>';
    printf(__('Sassy theme requires PHP >= 5.3.0, but you have PHP %s. Upgrade it or contact your hosting provider. Otherwise the theme will not work.', 'sassy'), phpversion());
    echo '</p></div>';
  }
  add_action('admin_notices', '_sassy_notices_php');

  /**
   * Frontend message.
   */
  function _sassy_notices_php_frontend() {
    wp_die(__('The site is under maintenance. We are working to get it back as soon as possible.', 'sassy'));
  }
  add_action('get_header', '_sassy_notices_php_frontend');

  return;
}


/**
 * Check if current page is login page.
 *
 * @return bool
 */
function sassy_is_login_page() {
  return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}


/**
 * Get absolute current url string.
 *
 * @global WP $wp
 *
 * @return string
 */
function sassy_current_url() {
  static $url = NULL;
  if ($url === NULL) {
    global $wp;
    return trailingslashit(home_url($wp->request));
  }
  return $url;
}


/**
 * Get sticky posts
 *
 * @param int $limit
 *
 * @return array
 */
function sassy_get_sticky_posts($limit = 5) {
  static $sticky_posts = NULL;
  if ($sticky_posts == NULL) {
    $sticky = get_option('sticky_posts', array());
    if ($sticky) {
      $args = array(
        'post_type'   => 'post',
        'numberposts' => $limit,
        'orderby'     => 'post_date',
        'order'       => 'DESC',
        'post__in'    => $sticky,
      );
      $sticky_posts = get_posts($args);
    }
    else {
      $sticky_posts = array();
    }
  }
  return $sticky_posts;
}


/**
 * Get related posts for given post.
 *
 * @param int $post_id
 * @param int $limit
 *
 * @return array
 */
function sassy_get_related_posts($post_id = NULL, $limit = 5) {

  if (!$post_id) {
    if (!is_single()) {
      return array();
    }
    $post_id = get_the_ID();
  }

  $tags = wp_get_post_tags($post_id);
  if ($tags) {
    $tag_ids = array();
    foreach ($tags as $individual_tag) {
      $tag_ids[] = $individual_tag->term_id;
    }
    $args = array(
      'tag__in'             => $tag_ids,
      'post__not_in'        => array(get_the_ID()),
      'post_type'           => get_post_type(),
      'posts_per_page'      => $limit,
      'numberposts'         => $limit,
      'ignore_sticky_posts' => TRUE,
    );
    return get_posts($args);
  }
  return array();
}


/**
 * Breadcrumbs
 *
 * @param string $args
 * @param bool $echo
 *
 * @return string|NULL
 */
function sassy_breadcrumbs($args, $echo = TRUE) {

  global $wp_query;
  if (empty($wp_query->query)) {
    return;
  }

  $breadcrumbs_args = array(
    'wrap_before' => '<nav class="breadcrumbs" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
    'wrap_after' => '</nav>',
    'delimiter' => ' <span class="breadcrumb-delimeter">' . (empty($args['delimeter']) ? '' : $args['delimeter']) . '</span> ',
    'home' => empty($args['home']) ? '' : __('Home'),
  );

  ob_start();
  if (function_exists('woocommerce_breadcrumb') && is_woocommerce()) {
    woocommerce_breadcrumb($breadcrumbs_args);
  }
  // BBPress has its own breadcrumb presentation before the forum content.
  // TODO integrate bbpress breadcrumbs here.
  elseif (function_exists('bbp_breadcrumb') && is_bbpress()) {
    return;
  }
  elseif (function_exists('yoast_breadcrumb')) {
    echo WPSEO_Breadcrumbs::breadcrumb( '', '', TRUE);
  }
  else {
    global $post;
    echo $breadcrumbs_args['wrap_before'];
    $breadcrumbs_trail = array();
    if (!empty($breadcrumbs_args['home'])) {
      $breadcrumbs_trail[] = '<a class="home" href="' . esc_attr(home_url()) . '">' . $breadcrumbs_args['home'] . '</a>';
    }
    if (is_category() || is_singular('post')) {
      // $breadcrumbs_trail[] = get_the_category_list($breadcrumbs_args['delimiter']);
    }
    elseif (is_singular('product') || is_tax('product_cat')) {
      if (is_singular('product')) {
        if (taxonomy_exists('product_cat')) {
          $ancestors = wp_get_post_terms(get_the_ID(), 'product_cat');
        }
        else {
          $ancestors = wp_get_post_terms(get_the_ID(), 'category');
        }
        $current_term = array_pop($ancestors);
      }
      else {
        $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
        $ancestors_ids = array_reverse(get_ancestors($current_term->term_id, get_query_var('taxonomy')));
        $ancestors = array();
        foreach ($ancestors_ids as $ancestor) {
          $ancestors[] = get_term($ancestor, get_query_var('taxonomy'));
        }
      }
      foreach ($ancestors as $ancestor) {
        $breadcrumbs_trail[] = sprintf('<a href="%s" title"%s">%s</a>', get_term_link($ancestor->slug, $ancestor->taxonomy), esc_attr($ancestor->name), esc_html($ancestor->name));
      }
      $breadcrumbs_trail[] = $current_term->name;
    }
    elseif (is_page()) {
      if ($post->post_parent){
        $ancestors = array_reverse(get_post_ancestors($post->ID), TRUE);
        foreach ($ancestors as $ancestor) {
          $breadcrumbs_trail[] = sprintf('<a href="%s" title="%s">%s</a>', get_permalink($ancestor), esc_attr(get_the_title($ancestor)), esc_attr(get_the_title($ancestor)));
        }
      }
    }
    elseif (is_search()) {
      $breadcrumbs_trail[] = __('Search');
      $breadcrumbs_trail[] = get_search_query() . '&hellip;';
    }
    elseif (is_tag()) {
      $breadcrumbs_trail[] = single_term_title('', TRUE);
    }
    elseif (is_month()) {
      $breadcrumbs_trail[] = sprintf(__('Archives: %s'), get_the_time('F, Y'));
    }
    elseif (is_year()) {
      $breadcrumbs_trail[] = sprintf(__('Archives: %s'), get_the_time('Y'));
    }
    elseif (is_author()) {
      $breadcrumbs_trail[] = __('Posts by %s', 'sassy');
    }
    elseif (is_day()) {
      $breadcrumbs_trail[] = sprintf(__('Archives: %s'), get_the_time('F jS, Y'));
    }
    elseif (is_home()) {
      $breadcrumbs_trail[] = single_post_title('', FALSE);
    }

    if (is_singular()) {
      $breadcrumbs_trail[] = get_the_title();
    }
    else {
      if (($pt = get_post_type())) {
        if (($pto = get_post_type_object($pt))) {
          $breadcrumbs_trail[] = $pto->labels->name;
        }
      }
    }

    $breadcrumbs_trail = array_filter($breadcrumbs_trail);

    if (!empty($_GET['paged'])) {
      $breadcrumbs_trail[] = sprintf(__('Page %s', 'sassy'), $_GET['paged']);
    }
    if (count($breadcrumbs_trail) > 1) {
      echo implode($breadcrumbs_args['delimiter'], $breadcrumbs_trail);
      echo $breadcrumbs_args['wrap_after'];
    }
    else {
      ob_end_clean();
      return;
    }
  }
  $breadcrumbs_markup = ob_get_clean();

  if ($echo) {
    echo $breadcrumbs_markup;
  }
  else {
    return $breadcrumbs_markup;
  }
}


/**
 * Build pagination links.
 *
 * @param string $type
 */
function sassy_pagination($type = '') {

  $open = '<nav class="pagination navigation" role="navigation">';
  $open .= '<span class="screen-reader-text">' . __('Post navigation') . '</span>';
  $close = '</nav>';

  // BBPress has its own breadcrumb presentation before the forum content.
  if (function_exists('bbp_breadcrumb') && is_bbpress()) {
    // TODO integrate bbpress paginator here.
    return;
  }
  elseif ($type == 'comments') {
    if (get_comment_pages_count() > 1 && get_option('page_comments')) {
      echo $open;
      echo paginate_comments_links();
      echo $close;
    }
  }
  elseif ($type == 'singular') {
    $defaults = array(
      'before'           => $open . '<div class="nav-links">',
      'after'            => '</div>' . $close,
      'link_before'      => '<span class="page-numbers">',
      'link_after'       => '</span>',
      'next_or_number'   => 'number',
      'separator'        => ' ',
      'nextpagelink'     => __('Next page'),
      'previouspagelink' => __('Previous page'),
      'pagelink'         => '%',
      'echo'             => 1
    );
    wp_link_pages($defaults);
  }
  elseif ($type == 'prevnext') {
    echo $open;
    previous_post_link();
    next_post_link();
    echo $close;
  }
  elseif ($type == 'archive') {
    echo $open;
    the_posts_pagination(array(
      'prev_text'          => __('Previous page'),
      'next_text'          => __('Next page'),
      'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page') . ' </span>',
    ));
    echo $close;
  }
}


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function sassy_is_categorized_blog() {
  static $state = NULL;
  if ($state === NULL) {
    $all_the_cool_cats = get_categories('fields=ids&hide_empty=1&number=2');
    $state = count($all_the_cool_cats) > 1;
  }
  return $state;
}


/**
 * Sassy theme setup
 */
function _sassy_setup() {

  require(__DIR__ . '/includes/helpers.php');

  // Main theme instruction
  require(__DIR__ . '/includes/theme.php');

  // Include BBPress
  if (function_exists('bbpress')) {
    require(__DIR__ . '/includes/integrations/bbpress.php');
  }

  // Include WooCommerce integration
  if (defined('WOOCOMMERCE_VERSION')) {
    require(__DIR__ . '/includes/integrations/woocommerce/woocommerce.php');
  }

  // Include SiteOriginPanels integraion
  if (defined('SITEORIGIN_PANELS_VERSION')) {
    require(__DIR__ . '/includes/integrations/siteorigin-panels.php');
  }
  else {
    require(__DIR__ . '/includes/integrations/no-layouting-plugin.php');
  }

  // Include various custom fields and types plugin integrations
  require(__DIR__ . '/includes/integrations/custom-fields.php');

  // Include miscellaneous third-party integrations
  require(__DIR__ . '/includes/integrations/misc.php');

  // Register layout post type
  require __DIR__ . '/includes/layouts.php';

  do_action('sassy_loaded');
}

// Setup
_sassy_setup();
