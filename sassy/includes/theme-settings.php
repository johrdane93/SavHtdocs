<?php


/**
 * Class SassySettings
 */
class SassySettings {


  /**
   * Setup sassy settings manager.
   */
  public static function setup() {

    add_theme_support('custom-background');
    add_theme_support('custom-header', array(
      'default-text-color' => '222',
      'width' => 269,
      'height' => 95,
      'flex-height'=> TRUE,
      'flex-width' => TRUE,
      'uploads' => TRUE,
      'wp-head-callback' => NULL,
      'admin-head-callback' => NULL,
      'admin-preview-callback' => NULL,
    ));

    add_action('customize_register' , array('SassySettings' , 'customizer_register'));
    add_action('customize_save', array('SassySettings', 'customizer_save'));

    // Fire theme setup action.
    do_action('sassy_after_theme_settings_setup');
  }


  /**
   * Get theme settings definition
   *
   * @return array
   */
  public static function options() {

    $settings = array();

    // General theme settings
    $settings['custom_html_head'] = array(
      'section' => 'settings-site',
      'label' => __('Custom head metatags', 'sassy'),
      'description' => __('just before &lt;/head&gt;', 'sassy'),
      'type' => 'textarea',
    );
    $settings['custom_html_body'] = array(
      'section' => 'settings-site',
      'label' => __('Custom head html', 'sassy'),
      'description' => __('just after &lt;body&gt;', 'sassy'),
      'type' => 'textarea',
    );
    $settings['custom_html_footer'] = array(
      'section' => 'settings-site',
      'label' => __('Custom footer html', 'sassy'),
      'description' => __('just before &lt;/body&gt;', 'sassy'),
      'type' => 'textarea',
    );
    $settings['custom_css'] = array(
      'section' => 'custom_styling',
      'label' => __('Custom CSS', 'sassy'),
      'type' => 'textarea',
      'default' => "/**\n * Your custom CSS rules here\n */",
      'input_attrs' => array(
        'rows' => 12,
      ),
    );
    $settings['custom_css_sass'] = array(
      'section' => 'custom_styling',
      'label' => __('Process the CSS code through theme\'s SASS processor.', 'sassy'),
      'type' => 'checkbox',
      'default' => FALSE,
    );

    // Apperance

    // System colors
    $settings['header_textcolor'] = array(
      '_builtin' => TRUE,
      'rewrite' => 'sassy_sanitize_color',
      'default' => '#333',
      'export_scss' => TRUE,
    );
    $settings['background_color'] = array(
      '_builtin' => TRUE,
      'rewrite' => 'sassy_sanitize_color',
      'default' => '#ededed',
      'export_scss' => TRUE,
    );
    $settings['appearance_color_foreground'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Main Foreground color', 'sassy'),
      'default' => '#222',
      'export_scss' => TRUE,
    );
    $settings['appearance_color_background'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Main Background color', 'sassy'),
      'default' => '#fff',
      'export_scss' => TRUE,
    );
    $settings['appearance_color_links'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Main links color', 'sassy'),
      'default' => '#00B819',
      'export_scss' => TRUE,
    );

    // Theme colors
    $settings['appearance_color_theme_primary'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Theme color - primary', 'sassy'),
      'default' => '#00B819',
      'export_scss' => TRUE,
    );
    $settings['appearance_color_theme_secondary'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Theme color - secondary', 'sassy'),
      'default' => '#ff4d00',
      'export_scss' => TRUE,
    );
    $settings['appearance_color_theme_foreground'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Theme color - foreground', 'sassy'),
      'default' => '#efefef',
      'export_scss' => TRUE,
    );
    $settings['appearance_color_theme_background'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Theme color - background', 'sassy'),
      'default' => '#343434',
      'export_scss' => TRUE,
    );

    // Neutral colors
    $settings['appearance_color_theme_neutral_active'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Neutral theme color (active)', 'sassy'),
      'default' => '#D1E4D3',
      'export_scss' => TRUE,
    );
    $settings['appearance_color_theme_neutral_inactive'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Neutral theme color (inactive)', 'sassy'),
      'default' => '#D5D5D5',
      'export_scss' => TRUE,
    );

    // Forms
    $settings['appearance_form_field_border'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Forms fields border', 'sassy'),
      'default' => '#b3b3b3',
      'export_scss' => TRUE,
    );
    $settings['appearance_form_field_foreground'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Forms fields foreground', 'sassy'),
      'default' => '',
      'export_scss' => TRUE,
    );
    $settings['appearance_form_field_background'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Forms fields background', 'sassy'),
      'default' => '#fff',
      'export_scss' => TRUE,
    );
    $settings['appearance_form_button_border'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Forms button border', 'sassy'),
      'default' => '#00B819',
      'export_scss' => TRUE,
    );
    $settings['appearance_form_button_foreground'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Forms button foreground', 'sassy'),
      'default' => '#fff',
      'export_scss' => TRUE,
    );
    $settings['appearance_form_button_background'] = array(
      'section' => 'colors',
      'type' => 'color',
      'label' => __('Forms button background', 'sassy'),
      'default' => '#00B819',
      'export_scss' => TRUE,
    );


    // Typography
    $settings['appearance_typography_rtl'] = array(
      '_builtin' => TRUE,
      'default' => is_rtl(),
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_text_justify'] = array(
      'section' => 'typography',
      'label' => __('Justify text', 'sassy'),
      'type' => 'checkbox',
      'default' => FALSE,
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_font_size'] = array(
      'section' => 'typography',
      'label' => __('Font Sizes', 'sassy'),
      'type' => 'number',
      'default' => 14,
      'input_attrs' => array(
        'min'   => 8,
        'max'   => 20,
        'step'  => 1,
      ),
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_letterspace'] = array(
      'section' => 'typography',
      'label' => __('Letter space', 'sassy'),
      'type' => 'number',
      'default' => 0,
      'input_attrs' => array(
        'min'   => -3,
        'max'   => 20,
        'step'  => 1,
      ),
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_lineheight'] = array(
      'section' => 'typography',
      'label' => __('Text line height', 'sassy'),
      'type' => 'number',
      'default' => 14,
      'input_attrs' => array(
        'min'   => 2,
        'max'   => 30,
        'step'  => 1,
      ),
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_wordspacing'] = array(
      'section' => 'typography',
      'label' => __('Word spacig', 'sassy'),
      'type' => 'number',
      'default' => 0,
      'input_attrs' => array(
        'min'   => -3,
        'max'   => 20,
        'step'  => 1,
      ),
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_fontfamily'] = array(
      'section' => 'typography',
      'label' => __('Font family', 'sassy'),
      'type' => 'text',
      'default' => 'Tahoma,Verdana,Segoe,sans-serif',
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_gfontfamily'] = array(
      'section' => 'typography',
      'label' => __('Add font from Google', 'sassy'),
      'type' => 'select',
      'choices' => array_merge(
        array('' => '- ' . __('None', 'sassy') . ' - '),
        sassy_get_google_fonts_list()
      ),
      'default' => '',
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_fontfamily_headings'] = array(
      'section' => 'typography',
      'label' => __('Headings font family', 'sassy'),
      'type' => 'text',
      'default' => '',
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_gfontfamily_headings'] = array(
      'section' => 'typography',
      'label' => __('Add font from Google to headings', 'sassy'),
      'type' => 'select',
      'choices' => array_merge(
        array('' => '- ' . __('None', 'sassy') . ' - '),
        sassy_get_google_fonts_list()
      ),
      'default' => '',
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_uppercase'] = array(
      'section' => 'typography',
      'label' => __('Uppercase headings', 'sassy'),
      'type' => 'select',
      'choices' => array(
        '' => __('None', 'sassy'),
        'all' => __('All titles', 'sassy'),
        'headings' => __('Only H1...H6 headings', 'sassy'),
        'widgets' => __('Widget titles', 'sassy'),
      ),
      'default' => '',
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_paragraphs'] = array(
      'section' => 'typography',
      'label' => __('Paragraph styling', 'sassy'),
      'type' => 'select',
      'choices' => array(
        '' => '- ' . __('Default', 'sassy') . ' - ',
        'none' => __('None', 'sassy'),
        'indent' => __('Indent', 'sassy'),
        'indentmore' => __('Indent when more than one', 'sassy'),
        'margin' => __('Bottom margin', 'sassy'),
      ),
      'default' => '',
      'export_scss' => TRUE,
    );
    $settings['appearance_typography_wordbreak'] = array(
      'section' => 'typography',
      'label' => __('Word breaks', 'sassy'),
      'type' => 'select',
      'choices' => array(
        '' => '- ' . __('Default', 'sassy') . ' - ',
        'none' => __('None', 'sassy'),
        'breakall' => __('Break words', 'sassy'),
        'breakhyphend' => __('Break with hyphends', 'sassy'),
      ),
      'default' => '',
      'export_scss' => TRUE,
    );

    // Form typography
    $settings['appearance_form_spacing'] = array(
      'section' => 'typography',
      'label' => __('Form field whitespace', 'sassy'),
      'type' => 'number',
      'default' => 4,
      'input_attrs' => array(
        'min'   => 0,
        'max'   => 30,
        'step'  => 1,
      ),
      'export_scss' => TRUE,
    );
    $settings['appearance_form_border'] = array(
      'section' => 'typography',
      'label' => __('Form border size', 'sassy'),
      'type' => 'number',
      'default' => 2,
      'input_attrs' => array(
        'min'   => 0,
        'max'   => 8,
        'step'  => 1,
      ),
      'export_scss' => TRUE,
    );

    $settings['decoration_smooth_scrolling'] = array(
      'section' => 'decoration',
      'label' => __('Smooth scrolling', 'sassy'),
      'type' => 'select',
      'choices' => array(
        0 => __('Disabled', 'sassy'),
        100 => __('Fast', 'sassy'),
        350 => __('Normal', 'sassy'),
        550 => __('Slow', 'sassy'),
      ),
      'default' => 0,
      'export_js' => TRUE,
    );
    $settings['decoration_scroll_to_top'] = array(
      'section' => 'decoration',
      'label' => __('Scroll to top button', 'sassy'),
      'type' => 'checkbox',
      'default' => FALSE,
      'export_js' => TRUE,
    );
    $settings['decoration_roundness'] = array(
      'section' => 'decoration',
      'label' => __('Roundness', 'sassy'),
      'description' => __('Roundness is set for some base elements, but layouts have options to use or not using it.', 'sassy'),
      'type' => 'range',
      'input_attrs' => array(
        'min'   => 0,
        'max'   => 10,
        'step'  => 1,
      ),
      'default' => 1,
      'export_scss' => TRUE,
    );
    $settings['decoration_shadow'] = array(
      'section' => 'decoration',
      'label' => __('Shadows', 'sassy'),
      'type' => 'range',
      'default' => 1,
      'input_attrs' => array(
        'min'   => 0,
        'max'   => 10,
        'step'  => 1,
      ),
      'export_scss' => TRUE,
    );

    // Miscellaneous
    $settings['post_types_attachments_visits'] = array(
      'section' => 'components',
      'label' => __('Allow attachments to have own pages', 'sassy'),
      'type' => 'checkbox',
      'default' => FALSE,
    );
    $settings['components_comments_show_notes'] = array(
      'section' => 'components',
      'label' => __('Show comment form notes', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'export_scss' => TRUE,
    );
    $settings['components_comments_allowed_tags'] = array(
      'section' => 'components',
      'label' => __('Show comments allowed tags', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'export_scss' => TRUE,
    );
    $settings['components_time_format'] = array(
      'section' => 'components',
      'label' => __('Comments time format', 'sassy'),
      'type' => 'select',
      'choices' => array(
        '' => __('Default', 'sassy'),
        'human' => __('Human', 'sassy'),
      ),
      'default' => 'human',
    );
    $settings['components_comment_avatar_size'] = array(
      'section' => 'components',
      'label' => __('Comment\'s avatar size', 'sassy'),
      'type' => 'select',
      'choices' => array(
        32 => 32,
        42 => 42,
        44 => 44,
        48 => 48,
        64 => 64,
        96 => 96,
        100 => 100,
        128 => 128,
        160 => 160,
      ),
      'default' => 44,
      'export_scss' => TRUE,
    );
    $settings['components_read_more_string'] = array(
      'section' => 'components',
      'label' => __('Read more string', 'sassy'),
      'type' => 'text',
      'default' => '&hellip;',
    );
    $settings['components_enable_searches_autocomplete'] = array(
      'section' => 'components',
      'label' => __('Enable autocomplete in searches', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'export_js' => TRUE,
    );
    $settings['components_pagination_style'] = array(
      'section' => 'components',
      'label' => __('Pagination style', 'sassy'),
      'type' => 'select',
      'choices' => array(
        'border' => __('Border', 'sassy'),
        'background' => __('Background', 'sassy'),
        'colorbackground' => __('Colored background', 'sassy'),
        'clean' => __('Clean', 'sassy'),
      ),
      'default' => 'border',
      'export_scss' => TRUE,
    );
    $settings['components_tabs_style'] = array(
      'section' => 'components',
      'label' => __('Tabs style', 'sassy'),
      'type' => 'select',
      'choices' => array(
        'clean' => __('Clean', 'sassy'),
        'border' => __('Border', 'sassy'),
        'color' => __('Colored', 'sassy'),
      ),
      'default' => 'clean',
      'export_scss' => TRUE,
    );

    $settings = apply_filters('sassy_theme_settings', $settings);

    // Because customizer relay on single get_theme_mod() calls, but we need performance as well.
    if (is_customize_preview()) {
      foreach ($settings as $setting => &$data) {
        if (!isset($data['value'])) {
          $data['value'] = get_theme_mod($setting, (isset($data['default']) ? $data['default'] : NULL));
          if (!empty($data['rewrite'])) {
            if (is_callable($data['rewrite'])) {
              $data['value'] = call_user_func($data['rewrite'], $data['value'], $data);
            }
            else {
              $data['value'] = sprintf($data['rewrite'], $data['value']);
            }
          }
        }
      }
    }
    else {
      $settings_vals = get_theme_mods();
      foreach ($settings as $setting => &$data) {
        if (!isset($data['value'])) {
          $data['value'] = isset($settings_vals[$setting])
            ? $settings_vals[$setting]
            : (isset($data['default']) ? $data['default'] : NULL);
          if (!empty($data['rewrite'])) {
            if (is_callable($data['rewrite'])) {
              $data['value'] = call_user_func($data['rewrite'], $data['value'], $data);
            }
            else {
              $data['value'] = sprintf($data['rewrite'], $data['value']);
            }
          }
        }
      }
    }

    return $settings;
  }


  /**
   * Customizer
   *
   * @param $wp_customize
   */
  public static function customizer_register(WP_Customize_Manager $wp_customize) {

    // Advanced customization
    $wp_customize->add_panel('settings', array(
      'capability' => 'edit_theme_options',
      'title' => __('Advanced customization', 'sassy'),
      'description' => __('General settings not related to the appearances and feel.', 'sassy'),
    ));
    $wp_customize->add_section('custom_styling', array(
      'title' => __('Custom CSS', 'sassy'),
      'capability' => 'edit_theme_options',
      'panel' => 'settings',
      'priority' => 0,
    ));
    $wp_customize->add_section('settings-site', array(
      'panel' => 'settings',
      'capability' => 'edit_theme_options',
      'title' => __('Custom markup', 'sassy'),
    ));

    // Content panel
    $wp_customize->add_panel('components', array(
      'capability' => 'edit_theme_options',
      'title' => __('Components', 'sassy'),
      'description' => __('Settings that are not appearance related.', 'sassy'),
    ));
    $wp_customize->add_section('components', array(
      'title' => __('Miscellaneous', 'sassy'),
      'panel' => 'components',
    ));
    $wp_customize->get_section('static_front_page')->panel = 'components';
    $wp_customize->get_section('header_image')->panel = 'components';
    $wp_customize->get_section('title_tagline')->panel = 'components';
    $wp_customize->get_section('header_image')->title = __('Logo and heading image', 'sassy');


    // Appearance
    $wp_customize->add_panel('appearance', array(
      'capability' => 'edit_theme_options',
      'title' => __('Appearance', 'sassy'),
    ));
    $wp_customize->add_section('decoration', array(
      'title' => __('Decoration', 'sassy'),
      'capability' => 'edit_theme_options',
      'panel' => 'appearance',
    ));
    $wp_customize->add_section('typography', array(
      'title' => __('Typography', 'sassy'),
      'capability' => 'edit_theme_options',
      'panel' => 'appearance',
    ));

    $wp_customize->get_section('background_image')->panel = 'appearance';
    $wp_customize->get_section('colors')->panel = 'appearance';

    // Go through all settings and attach to sections.
    foreach (self::options() as $setting_id => $setting_data) {

      if (!empty($setting_data['_builtin'])) {
        continue;
      }

      $setting_data_setting = $setting_data;
      $setting_data_setting['type'] = 'theme_mod';
      if (empty($setting_data_setting['jsrefresh'])) {
        $setting_data_setting['transport'] = 'refresh';
      }
      else {
        $setting_data_setting['transport'] = 'postMessage';
      }
      call_user_func(array($wp_customize, 'add_setting'), $setting_id, $setting_data_setting);

      $setting_data_control = $setting_data;
      $setting_data_control['settings'] = $setting_id;
      $wp_customize->add_control($setting_id, $setting_data_control);
    }
  }


  /**
   * Get single option element
   *
   * @param $name
   * @param $default
   *
   * @return mixed
   */
  public static function get($name, $default = NULL) {

    static $all = NULL;
    if ($all === NULL) {
      $all = self::options();
    }

    if (isset($all[$name])) {
      return $all[$name]['value'];
    }
    return $default;
  }


  /**
   * Save action
   *
   * @param $customizer
   */
  public static function customizer_save($customizer) {
    _sassy_clear_theme_data('css');
  }

}
