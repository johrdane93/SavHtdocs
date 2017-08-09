<?php

/**
 * Class SassyIntegrationsCustomField
 */
class SassyIntegrationsCustomFields {


  function __construct() {
    add_action('after_setup_theme', array($this, 'setup'));
  }


  /**
   * Setup
   */
  function setup() {

    // ACF integration on Post Content Element
    if (function_exists('acf')) {
      add_filter('sassy_widget_content_element_elements', array($this, 'acf_sassy_widget_content_element_elements'));
    }

    // WPCF integration on Post Content Element
    if (defined('WPCF_VERSION')) {
      add_filter('sassy_widget_content_element_elements', array($this,'wpcf_sassy_widget_content_element_elements'));
    }

    // CMB2
    if (defined('CMB2_LOADED')) {
      add_filter('sassy_widget_content_element_elements', array($this,'cmb2_sassy_widget_content_element_elements'));
    }

  }


  /**
   * Integrate ACF fields
   *
   * @param $elements
   *
   * @return mixed
   */
  function acf_sassy_widget_content_element_elements($elements) {
    $acf_groups = apply_filters('acf/get_field_groups', array());
    foreach ($acf_groups as $acf) {
      foreach (apply_filters('acf/field_group/get_fields', array(), $acf['id']) as $field) {
        $elements[$field['id']] = array(
          'label'    => sprintf('(ACF) %s: %s (%s)', $acf['title'], $field['label'], $field['type']),
          'callback' => array($this, 'acf_render_field'),
          'args'     => $field,
        );
      }
    }
    return $elements;
  }

  /**
   * TODO
   * Renderer for ACF
   *
   * @param $args
   */
  function acf_render_field($args) {
    if (!empty($args['name']) && ($field = get_field($args['name']))) {
      // id
      // label
      // class
      if ($args['type'] == 'image') {
        $alt = empty($field['alt']) ? $field['title'] : $field['alt'];
        printf('<img src="%s" alt="%s" width="%s" height="%s" />', $field['url'], $alt, $field['width'], $field['height']);
      }
      //elseif ($args['type'] == 'file') {
      //}
      else {
        the_field($args['name']);
      }
    }
  }


  /**
   * Integrate Types WPCF fields
   *
   * @param $elements
   *
   * @return mixed
   */
  function wpcf_sassy_widget_content_element_elements($elements) {

    foreach (wpcf_admin_fields_get_fields() as $field) {
      $elements[$field['meta_key']] = array(
        'label'    => sprintf('(WPCF) %s (%s)', $field['name'], $field['type']),
        'callback' => array($this, 'wpcf_render_field'),
        'args'     => $field,
      );
    }
    return $elements;
  }

  /**
   * TODO
   * Renderer for Types WPCF
   *
   * @param $args
   */
  function wpcf_render_field($args) {

    // File
    if ($args['type'] == 'file') {
      $urls = explode(' ', types_render_field($args['slug'], array('output' => 'raw')));
      $multiple = count($urls) > 1;
      if ($multiple) {
        echo '<ul>';
      }
      foreach ($urls as $url) {
        if ($multiple) {
          printf('<li><a href="%s" target="_blank">%s</a></li>', $url, basename($url));
        }
        else {
          printf('<a href="%s" target="_blank">%s</a>', $url, basename($url));
        }
      }
      if ($multiple) {
        echo '</ul>';
      }
    }

    // All others
    else {
      echo types_render_field($args['slug']);
    }

  }


  /**
   * Integrate Types WPCF fields
   *
   * @param $elements
   *
   * @return mixed
   */
  function cmb2_sassy_widget_content_element_elements($elements) {
    foreach (CMB2_Boxes::get_all() as $metabox) {
      foreach ($metabox->prop('fields') as $field_args) {
        $unsupported = array(
          'group', 'colorpicker', 'taxonomy_multicheck', 'multicheck', 'oembed'
        );
        if (in_array($field_args['type'], $unsupported)) {
          continue;
        }
        $elements[$metabox->cmb_id . '_' . $field_args['name']] = array(
          'label'    => sprintf('(CMB2) %s: %s', $metabox->prop('title'), $field_args['name']),
          'callback' => array($this, 'cmb2_render_field'),
          'args'     => array(
            'field'   => $field_args,
            'metabox' => $metabox->cmb_id
          ),
        );
      }
    }
    return $elements;
  }

  /**
   * TODO
   * Renderer for Types CMB2
   *
   * @param $args
   * @param $options
   */
  function cmb2_render_field($args, $options) {
    $value = cmb2_get_field_value($args['metabox'], $args['field']);
    if (!$value) {
      return;
    }

    if ($args['field']['type'] == 'file_list') {
      echo '<ul>';
      foreach ($value as $file) {
        echo '<li><a href="' . esc_attr($file) . '" rel="nofollow" target="_blank">' . basename($file) . '</a></li>';
      }
      echo '</ul>';
    }
    elseif ($args['field']['type'] == 'file') {
      echo '<a href="' . esc_attr($value) . '" rel="nofollow" target="_blank">' . basename($value) . '</a>';
    }
    elseif ($args['field']['type'] == 'image') {
      printf('<img src="%s" alt="%s" width="%s" height="%s" />', $value, esc_attr(basename($value)));
    }
    elseif ($args['field']['type'] == 'text_date_timestamp') {
      echo date(get_option('date_format'), $value);
    }
    elseif (is_scalar($value)) {

      echo $value;
    }
  }

}

return new SassyIntegrationsCustomFields();
