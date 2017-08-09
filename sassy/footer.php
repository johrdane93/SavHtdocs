  <?php

    global $__sassy_main_content;
    $__sassy_main_content = ob_get_clean();
    sassy_render_current_page();

    // Handle ajax requests to theme.
    if (defined('DOING_AJAX')) {
      return;
    }

    do_action('sassy_after_layout');

    wp_footer();
  ?>
  </body>
</html>
<?php

// Output whole page.
echo _sassy_ob_html(ob_get_clean());
