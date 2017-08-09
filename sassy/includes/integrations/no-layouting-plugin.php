<?php

/**
 * This file include hook attachments as fallback,
 * they could be closures as are not intended to be
 * removable and extendable by child-themes.
 */


define('SASSY_NOLAYOUTING_PLUGIN', TRUE);


/**
 * Main setup
 */
add_action('after_setup_theme', function() {

  register_nav_menu('no-layouting-menu', __('Main', 'sassy'));

});


/**
 * Register nolayoting sidebar
 */
add_action('widgets_init', function() {
  register_sidebar(array(
    'name' => __('Sidebar widgets', 'sassy'),
    'id' => "no-layouting-sidebar",
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>\n",
    'before_title' => '<div class="widget-title">',
    'after_title' => "</div>\n",
  ));
});


/**
 * Add mobile breakpoints
 */
add_filter('sassy_js_settings', function($settings) {
  $settings['mobile_behavior_breakpoint'] = 800;
  return $settings;
});


/**
 * Add headers
 */
add_action('sassy_before_layout', function() {

  echo '<div class="no-layouting-plugin">';
    echo '<div id="no-layouting-header" class="wrapper">';

      the_widget('SASSY_Widget_Header_Logo');

      the_widget('WP_Widget_Search');

      if (function_exists('WC')) {
        the_widget('WC_Widget_Cart');
      }

    echo '</div>';
    echo '<div class="the-wrapper-box">';

      the_widget('SASSY_Widget_Nav_Menu', array(
        'title' => '',
        'nav_menu' => '',
        'variant' => 'horizontal-menu',
        'responsive_variant' => 'responsive-hamburger-menu',
        'depth' => 3,
        'theme_location' => has_nav_menu('no-layouting-menu') ? 'no-layouting-menu' : '',
      ));

      if (is_active_sidebar('no-layouting-sidebar')) {
        echo '<aside class="the-sidebar widget-styled-titles">';
        dynamic_sidebar('no-layouting-sidebar');
        echo '</aside>';
      }

      echo '<div class="widget_sassy_main_loop">';

      the_widget('SASSY_Widget_Breadcrumbs');
});


/**
 * Add footers
 */
add_action('sassy_after_layout', function() {

      echo '</div>';
    echo '</div>';
    echo '<div id="no-layouting-footer" class="wrapper">';
    the_widget('WP_Widget_Text', array(
      'text' => get_bloginfo('description') . ' | ' . date('Y'),
    ));
    echo '</div>';

  echo '</div>';
});