<?php

/**
 * Singular post layout
 */

global $post;

$layout_post_id = sassy_get_request_layout_id(array('post' => $post));

if ($layout_post_id) {
  sassy_layout_render($layout_post_id);
}
else {
  get_template_part('templates/no-layout', get_post_type());
}
