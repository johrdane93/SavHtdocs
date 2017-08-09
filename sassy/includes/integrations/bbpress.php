<?php

/**
 * Class SassyIntegrationsBBPress
 *
 * Future integrations for BBPress goes here.
 */
class SassyIntegrationsBBPress{


  function __construct() {
    add_action('after_setup_theme', array($this, 'setup'));
  }


  /**
   * Setup
   */
  function setup() {
    add_filter('sassy_scss_settings', array($this, 'sassy_scss_settings'));
    add_filter('sassy_current_request_content_only', array($this, 'sassy_current_request_content_only'));
    add_filter('sassy_layout_selection_rule_skip_types', array($this, 'sassy_layout_selection_rule_skip_types'));
  }


  /**
   * If current viewed page is some BBPress page, then show only content.
   * @return mixed
   */
  function sassy_current_request_content_only() {
    return (is_bbpress());
  }


  /**
   * Alter SCSS settings.
   */
  function sassy_scss_settings($options) {
    $options['supports_bbpress'] = 1;
    return $options;
  }


  /**
   * Add rules to skip some of post type variants for selection rule
   */
  function sassy_layout_selection_rule_skip_types($types) {

    // And most discussions plugins use next types (not only BBPress)
    $types['forum'] = array('archive_entry');
    $types['topic'] = array('archive_entry');
    $types['reply'] = array('archive_entry');

    return $types;
  }

}

return new SassyIntegrationsBBPress();
