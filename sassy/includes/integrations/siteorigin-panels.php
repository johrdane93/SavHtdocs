<?php


/**
 * Class SassySiteOriginPanels
 */
class SassySiteOriginPanels {


  function __construct() {
    add_theme_support('siteorigin-panels');
    add_action('after_setup_theme', array($this, 'setup'));
  }


  function setup() {

    // Generic setup.
    remove_action('wp_enqueue_scripts', 'siteorigin_panels_default_styles_register_scripts', 5);
    remove_action('wp_enqueue_scripts', 'siteorigin_panels_enqueue_styles', 1);
    remove_action('wp_head', 'siteorigin_panels_print_inline_css', 12);
    remove_action('wp_footer', 'siteorigin_panels_print_inline_css');

    add_action('widgets_init', array($this, 'widgets_init'));

    add_filter('sassy_html_inject_css', array($this, 'sassy_html_inject_css'));
    add_filter('sassy_scss_settings', array($this, 'sassy_scss_settings'));
    add_filter('body_class', array($this, 'body_class'));
    add_filter('sassy_layout_render', array($this, 'sassy_layout_render'), 10, 2);
    add_filter('siteorigin_panels_style_get_measurements_list', array($this, 'siteorigin_panels_style_get_measurements_list'));
    add_filter('sassy_supported_measurements', array($this, 'siteorigin_panels_style_get_measurements_list'));

    add_filter('siteorigin_panels_wpcolorpicker_options', array($this, 'siteorigin_panels_wpcolorpicker_options'));
    add_filter('siteorigin_panels_settings',  array($this, 'siteorigin_panels_settings'), SASSY_HOOK_LAST_PNUM);
    add_filter('siteorigin_panels_settings_fields', array($this, 'siteorigin_panels_settings_fields'), SASSY_HOOK_LAST_PNUM);
    add_filter('siteorigin_panels_css_object', array($this, 'siteorigin_panels_css_object'), SASSY_HOOK_LAST_PNUM, 3);

    // Tweak layouts
    add_filter('siteorigin_panels_data', array($this, 'siteorigin_panels_data'), SASSY_HOOK_LAST_PNUM, 2);
    add_filter('siteorigin_panels_layout_classes', array($this, 'siteorigin_panels_layout_classes'), SASSY_HOOK_LAST_PNUM, 3);
    add_filter('siteorigin_panels_layout_attributes', array($this, 'siteorigin_panels_layout_attributes'), SASSY_HOOK_LAST_PNUM, 3);

    // Rows
    add_filter('siteorigin_panels_row_classes', array($this, 'siteorigin_panels_row_classes'), 10, 2);
    add_filter('siteorigin_panels_row_attributes', array($this, 'siteorigin_panels_row_attributes'), 10, 2);
    add_filter('siteorigin_panels_row_style_attributes', array($this, 'siteorigin_panels_row_style_attributes'), SASSY_HOOK_LAST_PNUM, 2);
    add_filter('siteorigin_panels_row_style_fields', array($this, 'siteorigin_panels_row_style_fields'), 10, 2);
    add_filter('siteorigin_panels_css_row_margin_bottom', array($this, 'siteorigin_panels_css_row_margin_bottom'), 10, 5);

    // Cells
    add_filter('siteorigin_panels_row_cell_attributes', array($this, 'siteorigin_panels_row_cell_attributes'), 10, 2);

    // Tweak widgets.
    add_filter('siteorigin_panels_widget_classes', array($this, 'siteorigin_panels_widget_classes'), 10, 4);
    add_filter('siteorigin_panels_widget_style_attributes', array($this, 'siteorigin_panels_widget_style_attributes'), 10, 2);
    add_filter('siteorigin_panels_widget_style_fields', array($this, 'siteorigin_panels_widget_style_fields'), 10, 2);
    add_filter('siteorigin_panels_widget_dialog_tabs', array($this, 'siteorigin_panels_widget_dialog_tabs'));
    add_filter('siteorigin_panels_widgets', array($this, 'siteorigin_panels_widgets'));

    // Do the sassy hooks.
    do_action('sassy_after_siteorigin_panels_setup');

  }


  /**
   * Add support for SCSS
   */
  function sassy_scss_settings($options) {
    $options['supports_siteorigin_panels'] = 1;
    return $options;
  }


  /**
   * Own siteorigin panels css outputing.
   *
   * @param $content
   *
   * @return string
   */
  function sassy_html_inject_css($content) {
    ob_start();
    siteorigin_panels_print_inline_css();
    return $content . ob_get_clean();
  }


  /**
   * Add Sassy's colors to the color picker
   */
  function siteorigin_panels_wpcolorpicker_options($options) {

    $colors = array();
    foreach (SassySettings::options() as $name => $info) {
      if (!empty($info['type']) && $info['type'] == 'color' && !empty($info['value'])) {
        $colors[] = $info['value'];
      }
    }
    $colors = array_unique($colors);
    if ($colors) {
      $options['palettes'] = $colors;
    }

    return $options;
  }


  /**
   * Unregister or register some widgets
   */
  function widgets_init() {
    // Remove the little brother.
    unregister_widget('SiteOrigin_Panels_Widgets_PostContent');
  }

  /**
   * Rewrite body classes;
   */
  function body_class($classes) {
    if (!empty($_GET['siteorigin_panels_live_editor'])) {
      $classes[] = 'sassy-theme-preview';
      $classes[] = 'siteorigin-panels-preview';
    }
    return $classes;
  }

  
  /**
   * Override default siteorigin panel measurements
   */
  function siteorigin_panels_style_get_measurements_list($list) {
    $list = array('em', '%', 'px');
    return $list;
  }


  /**
   * Because integrations this is the actual rendered for the layout
   */
  function sassy_layout_render($output, $layout_post_id) {

    $output = siteorigin_panels_render($layout_post_id);

    // TODO found another way to do this monkeytrick
    // Need to replace siteorigin hardcoded IDs with CSS classes to avoid collisions.
    // pattern like #<pl|pg|pgc>-<layoutID>
    $selection_rule = get_post_meta($layout_post_id, '_sassy_layout_selection_rule', TRUE);
    if (!empty($selection_rule['archive_entry'])) {
      global $siteorigin_panels_inline_css;
      if ($siteorigin_panels_inline_css) {
        $pats = array(
          "#pl-{$layout_post_id} "  => ".archive-entry-pl-{$layout_post_id} ",
          "#pg-{$layout_post_id} "  => ".archive-entry-pg-{$layout_post_id} ",
          "#pgc-{$layout_post_id} " => ".archive-entry-pgc-{$layout_post_id} ",
        );
        foreach ($siteorigin_panels_inline_css as &$val) {
          $val = strtr($val, $pats);
        }
      }
    }
    // XXX

    return $output;
  }


  /**
   * Remove some fields that should be not touched by the users
   */
  function siteorigin_panels_settings_fields($fields) {

    unset($fields['general']['fields']['post-types']['options']['sassy-layouts']);
    unset($fields['widgets']['fields']['title-html']);
    unset($fields['layout']['fields']['responsive']);
    unset($fields['layout']['fields']['mobile-width']);
    unset($fields['layout']['fields']['full-width-container']);

    return $fields;
  }


  /**
   * Alwayws set sassy-layouts in the supported post types;
   */
  function siteorigin_panels_settings($settings) {

    $settings['home-page'] = FALSE;
    $settings['home-page-default'] = FALSE;
    $settings['home-template'] = 'index.php';

    $settings['title-html'] = '<div class="widget-title">{{title}}</div>';

    $settings['post-types'][] = 'sassy-layouts';

    // $settings['responsive'] = TRUE;
    // $settings['mobile-width'] = 800;
    // $settings['margin-bottom'] = NULL;
    // $settings['margin-sides'] = 20;
    // $settings['copy-content'] = TRUE;
    $settings['inline-css'] = FALSE;

    // Mobile/responsive settings taken from sassy root layout.
    static $_sassy_layout_settings = NULL;
    if ($_sassy_layout_settings === NULL) {
      $sassy_root_layout = sassy_get_root_layout_id();
      $_sassy_layout_settings = get_post_meta($sassy_root_layout, '_sassy_layout_settings', TRUE);
    }
    $settings['responsive'] = !empty($_sassy_layout_settings['mobile_behavior_breakpoint']);
    $settings['mobile-width'] = !empty($_sassy_layout_settings['mobile_behavior_breakpoint']) ? $_sassy_layout_settings['mobile_behavior_breakpoint'] : 0;

    return $settings;
  }


  /**
   * Generate CSS styling block
   * Reimplement the logic from siteorigin panels because need it as CSS instead of inline style
   *
   * @param $settings
   * @return array
   */
  function _siteorigin_panels_settings_to_css($settings) {
    $css = array();

    if (!empty($settings['margin'])) {
      $css['margin'] = $settings['margin'];
    }

    if (!empty($settings['padding'])) {
      $css['padding'] = $settings['padding'];
    }

    if (!empty($settings['height'])) {
      $css['height'] = $settings['height'];
    }

    if (!empty($settings['width'])) {
      $css['width'] = $settings['width'];
    }

    if (!empty($settings['font_color'])) {
      $css['color'] = $settings['font_color'];
    }

    if (!empty($settings['border_color'])) {

      if (empty($settings['border_width'])) {
        $css['border'] = '1px solid ' . $settings['border_color'];
      }
      else {
        $css['border-width'] = $settings['border_width'];
        $css['border-style'] = 'solid';
        $css['border-color'] = $settings['border_color'];
      }
    }

    if (!empty($settings['background'])) {
      $css['background-color'] = $settings['background'];
    }

    if (!empty($settings['background_image_attachment'])) {
      $url = wp_get_attachment_image_src($settings['background_image_attachment'], 'full');
      if(!empty($url)) {
        $css['background-image'] = 'url(' . $url[0] . ')';
      }
      if ($settings['background_display'] == 'tile') {
        $settings['background-repeat'] = 'repeat';
      }
      elseif ($settings['background_display'] == 'tile') {
        $settings['background-repeat'] = 'no-repeat';
        $settings['background-size'] = 'cover';
      }
      elseif ($settings['background_display'] == 'center') {
        $settings['background-position'] = 'center center';
        $settings['background-repeat'] = 'no-repeat';
      }
    }
    return $css;
  }


  /**
   * Generate CSS styling for the layout
   */
  function siteorigin_panels_css_object($css, $panels_data, $post_id) {

    // Fix multiple loading same CSS (caused by cycling the archive items).
    static $cache = array();
    if (isset($cache[$post_id])) {
      $css = new SiteOrigin_Panels_Css_Builder();
      return $css;
    }
    $cache[$post_id] = TRUE;

    $is_archive_item = (!is_singular() && in_the_loop());

    // Root layout styling
    if (sassy_post_is_layout($post_id)) {

      // As next will not work then we should found
      // better way to exclude the responsive mobile width for non root layouts.
      // if (!sassy_layout_is_root($post_id)) {
      //   unset($css[<default mobile width>]);
      // }

      $layout_settings = get_post_meta($post_id, '_sassy_layout_settings', TRUE);

      // Global layout styling.
      $wrapper_default = array();
      
      // Breakpoints in the layout.
      if (!empty($layout_settings['breakpoint'])) {
        foreach ($layout_settings['breakpoint'] as $key => $breakpoint_width) {
          $wrapper = array();

          // Widths
          if (!empty($layout_settings['width'][$key])) {
            $wrapper['width'] = $layout_settings['width'][$key] . $layout_settings['width_measurement'][$key];
          }
          if (!empty($layout_settings['max_width'][$key])) {
            $wrapper['max-width'] = $layout_settings['max_width'][$key] . $layout_settings['max_width_measurement'][$key];
          }

          // Margins
          if (!empty($layout_settings['horizontal_margin'][$key])) {
            $wrapper['margin-left'] = $layout_settings['horizontal_margin'][$key] . $layout_settings['horizontal_margin_measurement'][$key];
            $wrapper['margin-right'] = $layout_settings['horizontal_margin'][$key] . $layout_settings['horizontal_margin_measurement'][$key];
          }
          if (!empty($layout_settings['vertical_margin'][$key])) {
            $wrapper['margin-top'] = $layout_settings['vertical_margin'][$key] . $layout_settings['vertical_margin_measurement'][$key];
            $wrapper['margin-bottom'] = $layout_settings['vertical_margin'][$key] . $layout_settings['vertical_margin_measurement'][$key];
          }

          if ($wrapper && $breakpoint_width) {
            if ($is_archive_item || !empty($layout_settings['box'])) {
              if ($is_archive_item && ($wrapper_default['width'] || $wrapper_default['max-width'])) {
                $wrapper_default['display'] = 'inline-block';
              }
              $css->add_css('#pl-' . $post_id, $wrapper, $breakpoint_width);
            }
            else {
              $css->add_css('#pl-' . $post_id . ' > .wrapper, #pl-' . $post_id . ' > .panel-grid > .wrapper', $wrapper, $breakpoint_width);
            }
          }
          elseif ($wrapper) {
            $wrapper_default = array_merge($wrapper_default, $wrapper);
          }
        }
      }

      // Add default styling.
      if ($wrapper_default) {
        if ($is_archive_item || !empty($layout_settings['box'])) {
          if ($is_archive_item && (!empty($wrapper_default['width']) || !empty($wrapper_default['max-width']))) {
            $wrapper_default['display'] = 'inline-block';
          }
          $css->add_css('#pl-' . $post_id, $wrapper_default);
        }
        else {
          $css->add_css('#pl-' . $post_id . ' > .wrapper, #pl-' . $post_id . ' > .panel-grid > .wrapper', $wrapper_default);
        }
      }

    }

    // Row styles
    foreach ($panels_data['grids'] as $grid_index => $grid_row) {
      if (!empty($grid_row['_is_sassy_layout'])) {
        $style = $this->_siteorigin_panels_settings_to_css($grid_row['style']);
        $style['margin-left'] = 0;
        $style['margin-right'] = 0;
        $css->add_css('#pg-' . $post_id . '-' . $grid_index, $style);
      }
    }

    // Widgets
    foreach ($panels_data['widgets'] as $widget_id => $widget) {
      if (empty($widget['panels_info']['style'])) {
        continue;
      }

      $widget_domelement_id = '#panel-' . $post_id . '-' . $widget['panels_info']['grid'] . '-' . $widget['panels_info']['cell'] . '-' . $widget['panels_info']['cell_index'];

      $widget_css = $this->_siteorigin_panels_settings_to_css($widget['panels_info']['style']);
      if ($widget_css) {
        $css->add_css('#pl-' . $post_id . ' ' . $widget_domelement_id, $widget_css);
      }

      // Link color should be done separately as they require different selector.
      if (!empty($widget['panels_info']['style']['link_color'])) {
        $css->add_css($widget_domelement_id . ' a', array(
          'color' => $widget['panels_info']['style']['link_color']
        ));
      }

    }

    return $css;
  }


  /**
   * #LAYOUT
   *
   * Set layout class
   */
  function siteorigin_panels_layout_classes($classes, $post_id, $panels_data) {

    // By some reason SiteOrigin Panels Builder widget adds some classes for current post
    // which could be overhead and extra pain, we prefere to remove them.
    if (strpos($post_id, 'w') === 0) {
      return array();
    }

    if (sassy_post_is_layout($post_id)) {

      $layout_type = get_post_meta($post_id, '_sassy_layout_type', TRUE);
      if ($layout_type == 'menu') {
        $classes[] = 'sub-menu';
      }
      else {
        $layout_settings = get_post_meta($post_id, '_sassy_layout_settings', TRUE);

        $classes[] = 'the-wrapper';
        if (!empty($layout_settings['box'])) {
          $classes[] = 'the-wrapper-box';
        }

        if (!empty($layout_settings['masonry'])) {
          wp_enqueue_script('masonry');
          $classes[] = 'sassy-masonry';
        }

        if (is_singular() && in_the_loop()) {
          $classes = array_merge($classes, get_post_class());
        }

      }
    }
    return $classes;
  }


  /**
   * #LAYOUT
   *
   * Alter Layout attibutes.
   */
  function siteorigin_panels_layout_attributes($attributes, $post_id, $panels_data) {

    // XXX Avoid ID collision when archive-entry.
    global $siteorigin_panels_current_post;
    $selection_rule = get_post_meta($siteorigin_panels_current_post, '_sassy_layout_selection_rule', TRUE);

    // Add singular classes.
    if (!empty($selection_rule['singular'])) {
      $class = $attributes['class'];
      if (is_singular()) {
        $class = implode(' ', get_post_class($class));
      }
      $attributes['class'] = $class;
    }

    // Add archive-entry classes.
    elseif (!empty($selection_rule['archive_entry'])) {
      static $i = 0;
      $class = $attributes['class'] . ' archive-entry archive-entry-' . $attributes['id'];
      if (in_the_loop()) {
        $class = implode(' ', get_post_class($class));
      }
      $attributes['class'] = $class;
      $attributes['id'] .= '-' . $i++;
    }
    // XXX

    return $attributes;
  }


  /**
   * #LAYOUT
   *
   * Override panels settings for the sassy layout panels.
   */
  function siteorigin_panels_data($panels_data, $post_id = NULL) {

    // Condition rules.
    if (!empty($panels_data['grids'])) {

      // Widgets condition rule.
      foreach ($panels_data['widgets'] as $widget_index => $widget) {
        if (!empty($widget['panels_info']['style']['visibility_rule']) && !sassy_compute_rule($widget['panels_info']['style']['visibility_rule'])) {
          unset($panels_data['widgets'][$widget_index]);
        }
      }

      // Rows condition rule.
      foreach ($panels_data['grids'] as $grid_index => $grid) {
        if (!empty($grid['style']['visibility_rule']) && !sassy_compute_rule($grid['style']['visibility_rule'])) {
          unset($panels_data['grids'][$grid_index]);
          foreach ($panels_data['widgets'] as $widget_index => $widget) {
            if ($widget['panels_info']['grid'] == $grid_index) {
              unset($panels_data['widgets'][$widget_index]);
            }
          }
          foreach ($panels_data['grid_cells'] as $grid_cell_index => $grid_cell) {
            if ($grid_cell['grid'] == $grid_index) {
              unset($panels_data['grid_cell'][$grid_cell_index]);
            }
          }
        }
      }

    }

    // Margins for sassy layouts only.
    if ($post_id && get_post_type($post_id) == 'sassy-layouts' && !empty($panels_data['grids'])) {
      foreach ($panels_data['grids'] as &$grid_info) {
        $grid_info['_is_sassy_layout'] = TRUE;
        $grid_info['style']['bottom_margin'] = empty($grid_info['style']['bottom_margin']) ? '0' : $grid_info['style']['bottom_margin'];
      }
    }
    return $panels_data;
  }


  /**
   * #ROW
   *
   * When need remove styling wrapper
   */
  function siteorigin_panels_row_style_attributes($style_attributes, $style_args) {
    if (!empty($style_attributes['data-stretch-type']) && $style_attributes['data-stretch-type'] == 'full') {
      return array('class' => array('wrapper'));
    }
    else {
      unset($style_attributes['style']);
      $style_attributes['class'][] = 'inner-wrapper';
      return $style_attributes;
    }
  }


  /**
   * #ROW
   *
   * Adding custom row attributes
   */
  function siteorigin_panels_row_attributes($attributes, $settings) {

    if (!empty($settings['style']['sassy_row_role'])) {
      $attributes['role'] = $settings['style']['sassy_row_role'];
    }

    // XXX Avoid ID collision when archive-entry.
    global $siteorigin_panels_current_post;
    $selection_rule = get_post_meta($siteorigin_panels_current_post, '_sassy_layout_selection_rule', TRUE);
    if (!empty($selection_rule['archive_entry'])) {
      static $i = 0;
      $attributes['class'] .= ' archive-entry-' . $attributes['id'];
      $attributes['id'] .= '-' . $i++;
    }
    // XXX

    return $attributes;
  }


  /**
   * #ROW
   *
   * Adding sassy classes to rows
   */
  function siteorigin_panels_row_classes($classes, $settings) {

    if (!empty($settings['_is_sassy_layout'])) {
      if (!empty($settings['style']['row_stretch'])) {
        $classes[] = 'wrapper-' . $settings['style']['row_stretch'];
      }
      else {
        $classes[] = 'wrapper';
      }
    }

    if (!empty($settings['style']['sassy_box_shadow'])) {
      $classes[] = 'box-shadow';
    }
    if (!empty($settings['style']['sassy_roundness'])) {
      $classes[] = 'roundness-light';
    }

    if (!empty($settings['style']['sassy_sticky_scroll'])) {
      $classes[] = 'sticky-scroll';
      $classes[] = 'sticky-scroll-' . $settings['style']['sassy_sticky_scroll'];
    }

    if (!empty($settings['style']['media_query_breakpoint'])) {
      $classes[] = 'mq-' . $settings['style']['media_query_breakpoint'];
    }

    return $classes;
  }


  /**
   * #ROW
   *
   * Override row margin for sassy layout panels
   */
  function siteorigin_panels_css_row_margin_bottom($margin_bottom, $grid, $gi, $panels_data, $post_id) {
    if (sassy_post_is_layout($post_id)) {
      $margin_bottom = isset($grid['style']['bottom_margin']) ? $grid['style']['bottom_margin'] : 0;
    }
    return $margin_bottom;
  }


  /**
   * #ROW
   *
   * Add sassy layout fields.
   */
  function siteorigin_panels_row_style_fields($fields, $post_id = 0) {

    $is_sassy_layout = $post_id ? sassy_post_is_layout($post_id) : TRUE;

    // Attributes
    if ($is_sassy_layout) {
      $fields['sassy_row_role'] = array(
        'name'            => __('Row role', 'sassy'),
        'type'            => 'select',
        'group'           => 'attributes',
        'description'     => __('Define the role of the row. Read more at <a href="http://www.w3.org/TR/wai-aria/roles#role_definitions" target="_blank">w3.org/TR/wai-aria/roles</a>.', 'sassy'),
        'options'         => array(
          ''              => __('None', 'sassy'),
          'header'        => 'header',
          'footer'        => 'footer',
          'banner'        => 'banner',
          'complementary' => 'complementary',
          'contentinfo'   => 'contentinfo',
          'definition'    => 'definition',
          'main'          => 'main',
          'menubar'       => 'menubar',
          'navigation'    => 'navigation',
          'note'          => 'note',
          'search'        => 'search',
          'widget'        => 'widget',
        ),
        'priority'        => 2,
      );

      $fields['visibility_rule'] = array(
        'name' => __('Visibility rule', 'sassy'),
        'type' => 'textarea',
        'group' => 'attributes',
        'description' => __('Sassy condition rule', 'sassy'),
        'priority' => 999,
      );
    }

    // Layouts
    $fields['media_query_breakpoint'] = array(
      'name' => __('Hidding breakpoint', 'sassy'),
      'type' => 'select',
      'group' => 'layout',
      'options' => sassy_available_breakpoints(),
      'description' => __('Hide the row when screen is smaller', 'sassy'),
      'priority' => 1,
    );

    if ($is_sassy_layout) {
      $fields['row_stretch']['description'] = __('Will not work if layout is in box mode', 'sassy');
    }
    else {
      unset($fields['row_stretch']);
    }

    if ($is_sassy_layout) {
      $fields['sassy_sticky_scroll'] = array(
        'name'        => __('Sticky scroll', 'sassy'),
        'type'        => 'select',
        'group'       => 'layout',
        'description' => __('The element will be sticky when page is scrolled.', 'sassy'),
        'options'     => array(
          ''              => __('None', 'sassy'),
          'top'           => __('On top', 'sassy'),
          'top-hidden'    => __('On top, hide by default', 'sassy'),
          'bottom'        => __('On bottom', 'sassy'),
          'bottom-hidden' => __('On bottom, hide by default', 'sassy'),
        ),
        'default'     => '',
        'priority'    => 1000,
      );
    }
    $fields['border_width'] = array(
      'name'     => __('Border line', 'siteorigin-panels'),
      'type'     => 'measurement',
      'group'    => 'design',
      'multiple' => TRUE,
      'priority' => 11,
    );
    $fields['padding']['priority'] = 5;
    $fields['height'] = array(
      'name' => __('Height', 'sassy'),
      'type' => 'measurement',
      'group' => 'layout',
      'description' => __('Set height if it is necessary.', 'sassy'),
      'priority' => 5,
    );

    // Design
    $fields['color'] = array(
      'name' => __('Color', 'sassy'),
      'type' => 'color',
      'group' => 'design',
      'priority' => 14,
    );
    $fields['sassy_box_shadow'] = array(
      'name' => __('Use theme shadows', 'sassy'),
      'description' => __('If shadows are set, then it will be used for this element.', 'sassy'),
      'type' => 'checkbox',
      'group' => 'design',
      'default' => FALSE,
      'priority' => 17,
    );
    $fields['sassy_roundness'] = array(
      'name' => __('Use theme roundness', 'sassy'),
      'description' => __('If roundness is set, then it will be used for this element.', 'sassy'),
      'type' => 'checkbox',
      'group' => 'design',
      'default' => FALSE,
      'priority' => 17,
    );

    return $fields;
  }


  /**
   * #CELL
   *
   * Alter cell attributes
   */
  function siteorigin_panels_row_cell_attributes($attributes, $panel_data) {

    // XXX Avoid ID collision when archive-entry
    global $siteorigin_panels_current_post;
    $selection_rule = get_post_meta($siteorigin_panels_current_post, '_sassy_layout_selection_rule', TRUE);
    if (!empty($selection_rule['archive_entry'])) {
      static $i = 0;
      $attributes['class'] .= ' archive-entry-' . $attributes['id'];
      $attributes['id'] .= '-' . $i++;
    }
    // XXX

    return $attributes;
  }


  /**
   * #WIDGET
   *
   * Remove styling attributes from widgets and move them to style tag
   */
  function siteorigin_panels_widget_style_attributes($style_attributes, $style_args) {
    return array();
  }


  /**
   * #WIDGET
   *
   * Adding widget classes
   */
  function siteorigin_panels_widget_classes($classes, $widget, $instance, $widget_info) {

    if (!empty($widget_info['style']['sassy_box_shadow'])) {
      $classes[] = 'box-shadow';
    }
    if (!empty($widget_info['style']['sassy_roundness'])) {
      $classes[] = 'roundness-light';
    }

    if (!empty($widget_info['style']['sassy_widget_title'])) {
      $classes[] = 'widget-styled-titles';
    }

    if (!empty($widget_info['style']['sassy_cell_widget_layout'])) {
      $classes[] = 'widget-' . $widget_info['style']['sassy_cell_widget_layout'];
    }
    if (!empty($widget_info['style']['sassy_cell_widget_layout_mobile'])) {
      $classes[] = 'widget-mobile-' . $widget_info['style']['sassy_cell_widget_layout_mobile'];
    }

    if (!empty($widget_info['style']['media_query_breakpoint'])) {
      $classes[] = 'mq-' . $widget_info['style']['media_query_breakpoint'];
    }

    if (!empty($widget_info['style']['media_query_breakpoint_collapsible'])) {
      $classes[] = 'mq-collapsible';
      $classes[] = 'mq-collapsible-' . $widget_info['style']['media_query_breakpoint_collapsible'];
    }

    return $classes;
  }


  /**
   * #WIDGET
   *
   * Add sassy settings
   */
  function siteorigin_panels_widget_style_fields($fields, $post_id = 0) {

    $is_sassy_layout = $post_id ? sassy_post_is_layout($post_id) : TRUE;

    if ($is_sassy_layout) {
      $fields['visibility_rule'] = array(
        'name'        => __('Visibility rule', 'sassy'),
        'type'        => 'textarea',
        'group'       => 'attributes',
        'description' => __('Sassy condition rule', 'sassy'),
        'priority'    => 999,
      );
    }

    // Layout
    $fields['media_query_breakpoint'] = array(
      'name' => __('Hidding breakpoint', 'sassy'),
      'type' => 'select',
      'group' => 'layout',
      'options' => sassy_available_breakpoints(),
      'description' => __('Hide the row when screen is smaller', 'sassy'),
      'priority' => 1,
    );
    $fields['media_query_breakpoint_collapsible'] = array(
      'name' => __('Breakpoint collapsible', 'sassy'),
      'type' => 'select',
      'group' => 'layout',
      'options' => sassy_available_breakpoints(),
      'description' => __('Make widget collapsible when screen is less than', 'sassy'),
      'priority' => 1,
    );
    $fields['sassy_cell_widget_layout'] = array(
      'name' => __('Element layout', 'sassy'),
      'type' => 'select',
      'options' => array(
        '' => __('Default', 'sassy'),
        'inline' => __('Inline', 'sassy'),
        'inline-center' => __('Centered', 'sassy'),
        'inline-left' => __('Inline left', 'sassy'),
        'inline-right' => __('Inline right', 'sassy'),
      ),
      'group' => 'layout',
      'default' => '',
      'priority' => 4,
    );
    $fields['sassy_cell_widget_layout_mobile'] = array(
      'name' => __('Element layout on mobile behavior', 'sassy'),
      'type' => 'select',
      'options' => array(
        '' => __('Default', 'sassy'),
        'inline' => __('Inline', 'sassy'),
        'inline-center' => __('Centered', 'sassy'),
        'inline-left' => __('Inline left', 'sassy'),
        'inline-right' => __('Inline right', 'sassy'),
      ),
      'group' => 'layout',
      'default' => '',
      'priority' => 4,
    );
    $fields['width'] = array(
      'name' => __('Width', 'sassy'),
      'type' => 'measurement',
      'group' => 'layout',
      'description' => __('Width of the widget.', 'sassy'),
      'priority' => 5,
    );
    $fields['height'] = array(
      'name' => __('Height', 'sassy'),
      'type' => 'measurement',
      'group' => 'layout',
      'description' => __('Set height if it is necessary.', 'sassy'),
      'priority' => 5,
    );

    $fields['padding']['priority'] = 6;

    $fields['margin'] = array(
      'name' => __('Margin', 'siteorigin-panels'),
      'type' => 'measurement',
      'group' => 'layout',
      'multiple' => TRUE,
      'priority' => 6,
    );

    // Design
    $fields['border_width'] = array(
      'name' => __('Border line', 'siteorigin-panels'),
      'type' => 'measurement',
      'group' => 'design',
      'multiple' => TRUE,
      'priority' => 11,
    );
    $fields['link_color'] = array(
      'name' => __('Links color', 'sassy'),
      'type' => 'color',
      'group' => 'design',
      'priority' => 14,
    );
    $fields['sassy_widget_title'] = array(
      'name' => __('Style widget titles', 'sassy'),
      'type' => 'checkbox',
      'group' => 'design',
      'default' => FALSE,
      'priority' => 16,
    );
    $fields['sassy_box_shadow'] = array(
      'name' => __('Use theme shadows', 'sassy'),
      'description' => __('If shadows are set, then it will be used for this element.', 'sassy'),
      'type' => 'checkbox',
      'group' => 'design',
      'default' => FALSE,
      'priority' => 17,
    );
    $fields['sassy_roundness'] = array(
      'name' => __('Use theme roundness', 'sassy'),
      'description' => __('If roundness is set, then it will be used for this element.', 'sassy'),
      'type' => 'checkbox',
      'group' => 'design',
      'default' => FALSE,
      'priority' => 17,
    );

    return $fields;
  }


  /**
   * #WIDGET
   *
   * Add sassy-theme widgets group
   */
  function siteorigin_panels_widget_dialog_tabs($tabs) {
    $tabs[] = array(
      'title' => __('Sassy', 'sassy'),
      'filter' => array(
        'groups' => array('sassy')
      ),
    );
    return $tabs;
  }


  /**
   * #WIDGET
   *
   * Set group for the sassy widgets
   */
  function siteorigin_panels_widgets($widgets) {
    foreach ($widgets as $widget_id => &$widget) {
      if (stripos($widget_id, 'sassy') !== FALSE) {
        $widget['groups'][] = 'sassy';
      }
    }
    return $widgets;
  }


}

return new SassySiteOriginPanels();
