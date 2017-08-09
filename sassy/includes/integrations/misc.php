<?php

/**
 * Class SassyIntegrationsMisc
 */
class SassyIntegrationsMisc {


  function __construct() {
    add_action('after_setup_theme', array($this, 'setup'));
  }


  /**
   * Setup
   */
  function setup() {

    // Support Jetpack site logo feature
    add_theme_support('site-logo', array(
      'size' => 'medium',
    ));

    add_action('wp_footer', array($this, 'wp_footer'));

    add_filter('sassy_scss_settings', array($this, 'sassy_scss_settings'));
    add_filter('option_msp_advanced', array($this, 'option_msp_advanced'));

    add_filter('sassy_layout_selection_rule_skip_types', array(
      $this,
      'sassy_layout_selection_rule_skip_types'
    ));

  }


  /**
   * Alter SCSS settings.
   */
  function sassy_scss_settings($options) {
    $options['supports_ninjaforms'] = (int) defined('NF_PLUGIN_VERSION');
    return $options;
  }


  /**
   * Do on footer integrations
   */
  function wp_footer() {
  }


  /**
   * Override MasterSlider to alway append the scripts.
   */
  function option_msp_advanced($value) {
    $value['allways_load_ms_assets'] = 'on';
    return $value;
  }


  /**
   * Add rules to skip some of post type variants for selection rule
   */
  function sassy_layout_selection_rule_skip_types($types) {

    // Plugin specifics
    $types['ml-slider'] = array('singular', 'archive', 'archive_entry');
    $types['wysijap'] = array('singular', 'archive', 'archive_entry');

    return $types;
  }

}


// Init miscalaneus init.
return new SassyIntegrationsMisc();
