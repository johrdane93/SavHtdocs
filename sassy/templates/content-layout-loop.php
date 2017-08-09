<?php

/**
 * Archive posts loop layout
 */
global $post;
global $wp_query;

$backup_wp_query = $wp_query;
$wp_query->is_home = FALSE;

if ($wp_query->get('sassy_template')) {
  $layout_post_id = $wp_query->get('sassy_template');
}
else {
  $layout_post_id = sassy_get_request_layout_id();
}

if ($layout_post_id) {
  sassy_layout_render($layout_post_id);
}
else {
  get_template_part('templates/no-layout', get_post_type());
}

$wp_query = $backup_wp_query;