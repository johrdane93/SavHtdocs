<?php

if (!defined('DOING_AJAX')) {
  get_header();
}

$layout_post_id = sassy_get_request_layout_id('final=1');

if (have_posts()) {

  // Force some pages only to show the content.
  if ( (is_page() && is_front_page()) || apply_filters('sassy_current_request_content_only', FALSE, $layout_post_id)) {
    the_post();
    the_content();
  }
  else {

    while (have_posts()) {
      the_post();

      if ($layout_post_id) {
        sassy_layout_render($layout_post_id);
      }
      else {
        get_template_part('templates/no-layout', get_post_type());
      }

    }
  }

  if (!$layout_post_id && !is_singular()) {
    sassy_pagination('archive');
  }
}

else {
  ?>
  <div class="message message-info">
    <?php _e('No posts found.')?>
  </div>
<?php
}

if (!defined('DOING_AJAX')) {
  get_footer();
}
