<?php

register_widget('SASSY_Widget_Header_Logo');
register_widget('SASSY_Widget_User_Profile');
register_widget('SASSY_Widget_Pages_Subnav');
register_widget('SASSY_Widget_Main_Loop');
register_widget('SASSY_Widget_Breadcrumbs');
register_widget('SASSY_Widget_Pagination');
register_widget('SASSY_Widget_Related_Posts');
register_widget('SASSY_Widget_Nav_Menu');
register_widget('SASSY_Widget_Login_Form');
register_widget('SASSY_Widget_Content_Element');

// We not need from default WP navigation widgets.
unregister_widget('WP_Nav_Menu_Widget');


/**
 * Theme header logo
 */
class SASSY_Widget_Header_Logo extends WP_Widget {

  function __construct() {
    parent::__construct(FALSE, __('(sassy) Header Logo', 'sassy'));
  }

  function form($instance) {
    $instance = wp_parse_args($instance, array('max_width' => '', 'max_height' => ''));
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('max_width')?>">
        <?php _e('Max width:', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('max_width')?>" name="<?php echo $this->get_field_name('max_width')?>" type="text" value="<?php echo esc_attr($instance['max_width'])?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('max_height')?>">
        <?php _e('Max height:', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('max_height')?>" name="<?php echo $this->get_field_name('max_height')?>" type="text" value="<?php echo esc_attr($instance['max_height'])?>" />
    </p>

  <?php
  }

  function widget( $args, $instance ) {

    echo $args['before_widget'];

    $instance = wp_parse_args($instance, array('max_width' => '', 'max_height' => ''));

    $header_text_color = get_header_textcolor();

    if (get_header_image()) {

      $style = '';
      if (!empty($instance['max_width'])) {
        $style .= 'max-width:' . esc_attr($instance['max_width']) . ';';
      }
      if (!empty($instance['max_height'])) {
        $style .= 'max-height:' . esc_attr($instance['max_height']) . ';';
      }
      if ($style) {
        $style = ' style="' . $style . '"';
      }

      $header_image_width  = get_custom_header()->width;
      $header_image_height = get_custom_header()->height;

      ?>
      <a class="header-logo-image header-logo-link" href="<?php echo esc_url(home_url())?>" title="<?php _e('Front page')?>" rel="home">
        <img class="header-logo" src="<?php header_image()?>" alt="<?php bloginfo('name')?>" width="<?php echo $header_image_width?>" height="<?php echo $header_image_height?>" <?php echo $style?> />
      </a>
      <?php
    }
    else {
      ?>
      <a class="header-logo-text header-logo-link" rel="nofollow" href="<?php echo esc_url(home_url('/' ))?>">
        <?php bloginfo('name')?>
      </a>
      <?php
    }
    if ($header_text_color != 'blank'):?>
      <div class="header-logo-description">
        <?php bloginfo('description')?>
      </div>
    <?php endif;

    echo $args['after_widget'];

  }
}


/**
 * Class SASSY_Widget_User_Profile
 */
class SASSY_Widget_User_Profile extends WP_Widget {

  function __construct() {
    parent::__construct(FALSE, __('(sassy) User Profile', 'sassy'), array('description' => ''));
  }

  function form($instance) {

    $instance = wp_parse_args($instance, array('title' => '', 'style' => 'full', 'nav_menu' => ''));

    $menus = wp_get_nav_menus();

    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title')?>">
        <?php _e('Title:', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('hidewhennouser')?>">
        <input id="<?php echo $this->get_field_id('hidewhennouser')?>" name="<?php echo $this->get_field_name('hidewhennouser')?>" value="1" type="checkbox" <?php checked(!empty($instance['hidewhennouser']), TRUE)?> />
        <?php _e('Hide for anonymous users', 'sassy')?>
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('style')?>"><?php _e('Style', 'sassy')?></label>
      <select id="<?php echo $this->get_field_id('style')?>" name="<?php echo $this->get_field_name('style')?>">
        <option <?php selected('icon', $instance['style'])?> value="icon">icon</option>
        <option <?php selected('iconname', $instance['style'])?> value="iconname">icon+name</option>
        <option <?php selected('full', $instance['style'])?> value="full">full</option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('nav_menu')?>"><?php _e('Show menu in popup', 'sassy')?></label>
      <select id="<?php echo $this->get_field_id('nav_menu')?>" name="<?php echo $this->get_field_name('nav_menu')?>">
        <option value="0"><?php _e('&mdash; Select &mdash;', 'sassy')?></option>
        <?php
        foreach ( $menus as $menu ) {
          echo '<option value="' . $menu->term_id . '"'
            . selected( $instance['nav_menu'], $menu->term_id, false )
            . '>'. esc_html( $menu->name ) . '</option>';
        }
        ?>
      </select>
    </p>
    <?php
  }

  function widget($args, $instance) {

    $instance = wp_parse_args($instance, array('title' => '', 'style' => 'icon', 'nav_menu' => ''));

    $user = wp_get_current_user();

    if (!empty($instance['hidewhennouser']) && !$user) {
      return;
    }

    $style = empty($instance['style']) ? 'full' : $instance['style'];

    echo $args['before_widget'];

    $instance['title'] = apply_filters('widget_title', $instance['title']);
    if ($instance['title']) {
      echo $args['before_title'] . $instance['title'] . $args['after_title'];
    }

    if (!empty($instance['nav_menu'])) {
      $nav_menu = wp_get_nav_menu_object($instance['nav_menu']);
      ob_start();
      wp_nav_menu(array(
        'fallback_cb' => '',
        'menu' => $nav_menu,
        'container' => NULL,
        'menu_class' => 'sub-menu single-sub-menu',
        'return' => TRUE,
      ));
      $menu_markup = ob_get_clean();
    }
    else {
      $menu_markup = '';
    }

    echo '<ul class="account sassy-user-profile-widget-style-' . $style . ' horizontal-menu menu responsive-popup-menu">';

    $login_url = apply_filters('sassy_user_login_url', wp_login_url());
    $user_url = apply_filters('sassy_user_profile_url', get_edit_user_link($user->ID));

    $login_register_text =  __('Log In');
    if (get_option('users_can_register')) {
      $login_register_text .= ' ' . __('or')  . ' ' . __('Register');
    }

    echo '<li class="menu-item">';
    if ($style == 'full') {
      echo get_avatar(empty($user->ID) ? 0 : $user->ID, SassySettings::get('components_comment_avatar_size'));
      echo '<span class="info">';
      if (empty($user->ID)) {
        echo '<a rel="nofollow" href="' . $login_url . '"><span class="name">' . $login_register_text . '</span></a>';
      }
      else {
        echo '<a rel="nofollow" href="' . $user_url . '"><span class="name">' . $user->get('display_name') . '</span></a>';
      }
      echo '</span>';
    }
    elseif ($style == 'menu') {
      if (empty($user->ID)) {
        echo '<a rel="nofollow" href="' . $login_url . '"><span class="name">' . $login_register_text . '</span></a>';
      }
      else {
        echo '<a rel="nofollow" href="' . $user_url . '"><span class="name">' . $user->get('display_name') . '</span></a>';
      }
    }
    else {
      if (empty($user->ID)) {
        echo '<a rel="nofollow" href="' . $login_url . '"><span class="name">' . $login_register_text . '</span></a>';
      }
      else {
        echo '<a rel="nofollow" href="' . $user_url . '"><span class="name">' . $user->get('display_name') . '</span></a>';
      }
    }
    echo $menu_markup;
    echo '</li>';

    echo '</ul>';
    echo $args['after_widget'];
  }
}


/**
 * Class SASSY_Widget_Breadcrumbs
 */
class SASSY_Widget_Breadcrumbs extends WP_Widget {

  function __construct() {
    parent::__construct(FALSE, __('(sassy) Breadcrumbs', 'sassy'), array('description' => 'hello world'));
  }

  function form($instance) {
    $instance = wp_parse_args($instance, array('delimeter' => '/'));
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('home')?>">
        <?php _e('Show home item', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('home')?>" name="<?php echo $this->get_field_name('home')?>" value="1" type="checkbox" <?php checked(!empty($instance['home']), TRUE)?> />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('delimeter')?>">
        <?php _e('Delimeter char', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('delimeter')?>" name="<?php echo $this->get_field_name('delimeter')?>" type="text" value="<?php echo esc_attr($instance['delimeter'])?>" />
    </p>
  <?php
  }

  function widget($args, $instance) {

    // Do not show breadcrumbs on home and frontpages.
    if (is_front_page() || is_home()) {
      return;
    }

    $instance = wp_parse_args($instance, array('delimeter' => '/' ));
    $instance['home'] = !empty($instance['home']);
    $instance['delimeter'] = htmlspecialchars($instance['delimeter']);
    $breadcrumbs = sassy_breadcrumbs($instance, FALSE);
    if ($breadcrumbs) {
      echo $args['before_widget'];
      echo $breadcrumbs;
      echo $args['after_widget'];
    }
  }
}


/**
 * Class SASSY_Widget_Pagination
 */
class SASSY_Widget_Pagination extends WP_Widget {

  function __construct() {
    parent::__construct(FALSE, __('(sassy) Archive items pagination', 'sassy'));
  }

  function widget($args, $instance) {
    echo $args['before_widget'];
    sassy_pagination('archive');
    echo $args['after_widget'];
  }
}


/**
 * Class SASSY_Widget_Breadcrumbs
 */
class SASSY_Widget_Related_Posts extends WP_Widget {

  function __construct() {
    parent::__construct(FALSE, __('(sassy) Related posts', 'sassy'));
  }

  function form($instance) {
    $instance = wp_parse_args($instance, array('title' => ''));
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title')?>">
        <?php _e('Title:', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" />
    </p>
    <?php
  }

  function widget($args, $instance) {

    if (!is_single()) {
      return;
    }

    $related_posts = sassy_get_related_posts();

    if ($related_posts) {
      echo $args['before_widget'];
      $instance['title'] = apply_filters('widget_title', (empty($instance['title']) ? '' : $instance['title']));
      if ($instance['title']) {
        echo $args['before_title'] . $instance['title'] . $args['after_title'];
      }
      echo '<ul>';
      foreach ($related_posts as $post):?>
        <li>
          <a href="<?php echo get_permalink($post->ID)?>">
            <?php echo $post->post_title?>
          </a>
        </li>
      <?php endforeach;
      echo '</ul>';
      echo $args['after_widget'];
    }
  }
}


/**
 * Theme widgets definition
 */
class SASSY_Widget_Main_Loop extends WP_Widget {

  function __construct() {
    parent::__construct(FALSE, __('(sassy) Context placeholder', 'sassy'), array(
      'description' => __('This is default context presenter, it display the children layouts or main content, so you need this widget in most cases.', 'sassy'),
    ));
  }

  function form($instance) {
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('print_wrapper')?>">
        <input id="<?php echo $this->get_field_id('print_wrapper')?>" name="<?php echo $this->get_field_name('print_wrapper')?>" type="checkbox" value="1" <?php checked(!empty($instance['print_wrapper']), TRUE)?> />
        <?php _e('Add wrappers', 'sassy')?>
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('user_ajax_pagers')?>">
        <input id="<?php echo $this->get_field_id('user_ajax_pagers')?>" name="<?php echo $this->get_field_name('user_ajax_pagers')?>" type="checkbox" value="1" <?php checked(!empty($instance['user_ajax_pagers']), TRUE)?> />
        <?php _e('Use AJAX pager', 'sassy')?>
      </label>
    </p>
  <?php
  }

  function widget( $args, $instance ) {
    global $__sassy_main_content;

    if (!$__sassy_main_content) {
      return;
    }

    if (!empty($instance['print_wrapper'])) {
      echo $args['before_widget'];
    }

    echo $__sassy_main_content;

    if (!empty($instance['print_wrapper'])) {
      echo $args['after_widget'];
    }

  }
}


/**
 * Class SASSY_Widget_Pages_Subnav
 */
class SASSY_Widget_Pages_Subnav extends WP_Widget {

  function __construct() {
    parent::__construct(false, __('(sassy) Pages Navigation', 'sassy'));
  }

  function form($instance) {
    $instance = wp_parse_args($instance, array('title' => ''));
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title')?>">
        <?php _e('Title:', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" />
    </p>
  <?php
  }

  function widget($args, $instance) {

    $instance = wp_parse_args($instance, array('title' => ''));

    global $post;

    if (!$post) {
      return FALSE;
    }

    $return_state = FALSE;

    if (is_page()) {

      echo $args['before_widget'];

      $instance['title'] = apply_filters('widget_title', $instance['title']);

      if ($instance['title']) {
        echo $args['before_title'] . $instance['title'] . $args['after_title'];
      }

      $classes_to_replace = array(
        'current_page_ancestor' => 'current_page_item current_page_ancestor',
        'current_page_parent' => 'current_page_item current_page_parent',
      );
      $ancestors = get_post_ancestors($post->ID);
      $root = array_pop($ancestors);
      $current = ($post->post_parent && $post->post_parent !== $root) ? $post->post_parent : $post->ID;

      $query_args = array(
        'child_of' => $current,
        'depth' => 1,
        'title_li' => '',
        'echo' => 0,
      );

      $tmp = wp_list_pages($query_args);

      if ($tmp) {
        echo '<div class="widget">';
        echo '<div class="widget-title">' . get_the_title($current) . '</div>';
        echo '<ul class="menu">' . strtr($tmp, $classes_to_replace) . '</ul>';
        echo '</div>';
        $return_state = TRUE;
      }
      unset($tmp);

      if ($root && $root !== $current) {
        $query_args = array(
          'child_of' => $root,
          'depth' => 1,
          'title_li' => '',
          'echo' => 0,
        );
        $tmp = wp_list_pages($query_args);
        if ($tmp) {
          echo '<div class="widget">';
          echo '<div class="widget-title">' . get_the_title($root) . '</div>';
          echo '<ul class="menu">' . strtr($tmp, $classes_to_replace) . '</ul>';
          echo '</div>';
          $return_state = TRUE;
        }
        unset($tmp);
      }

      echo $args['after_widget'];
    }

    return $return_state;
  }
}


/**
 * Class SASSY_Widget_Nav_Menu
 */
class SASSY_Widget_Nav_Menu extends WP_Widget {

  function __construct() {
    parent::__construct( FALSE, __('(sassy) Custom Menu', 'sassy'), array('description' => __('Add a custom menu to your sidebar.', 'sassy')));
  }

  function widget($args, $instance) {

    $instance = wp_parse_args($instance, array('title' => '', 'nav_menu' => '', 'variant' => '', 'responsive_variant' => '', 'depth' => 2, 'theme_location' => ''));
    $nav_menu = NULL;
    if ($instance['nav_menu']) {
      $nav_menu = wp_get_nav_menu_object($instance['nav_menu']);
      if (!$nav_menu) {
        return;
      }
    }
    else {
      $nav_menu = '';
    }

    echo $args['before_widget'];

    $instance['title'] = apply_filters('widget_title', (empty($instance['title']) ? '' : $instance['title']));
    if ($instance['title']) {
      echo $args['before_title'] . $instance['title'] . $args['after_title'];
    }

    $classes = array();
    if (!empty($instance['variant'])) {
      $classes[] = $instance['variant'];
    }
    if (!empty($instance['responsive_variant'])) {
      $classes[] = $instance['responsive_variant'];
    }
    if (!empty($instance['color'])) {
      $classes[] = 'menu-color';
    }
    if (!empty($instance['show_description'])) {
      $classes[] = 'show-descriptions';
    }

    $menu_args = array(
      'fallback_cb' => '',
      'menu' => $nav_menu,
      'container_class' => implode(' ', $classes),
      'menu_class' => 'menu',
      'echo' => TRUE,
      'depth' => $instance['depth'],
      'theme_location' => $instance['theme_location'],
    );

    if ($nav_menu || $menu_args['theme_location']) {
      wp_nav_menu($menu_args);
    }
    else {
      $menu_args['title_li'] = NULL;
      $menu_args['echo'] = FALSE;
      echo '<div class="' . $menu_args['container_class'] . '"><ul class="menu">';
      $output = wp_list_pages($menu_args);
      echo strtr($output, array(
        'page_item page-item-' => 'menu-item page_item page-item-',
        'page_item_has_children' => 'page_item_has_children menu-item-has-children',
        'class=\'children\'' => 'class="children sub-menu"',
      ));
      echo '</ul></div>';
    }

    echo $args['after_widget'];
  }

  function form($instance) {

    $instance = wp_parse_args($instance, array('title' => '', 'nav_menu' => '', 'variant' => '', 'responsive_variant' => '', 'depth' => 2));

    // Get menus
    $menus = wp_get_nav_menus( array('orderby' => 'name'));

    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title')?>"><?php _e('Title:', 'sassy') ?></label>
      <input type="text" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" value="<?php echo esc_attr($instance['title'])?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('nav_menu')?>"><?php _e('Select Menu:', 'sassy')?></label>
      <select id="<?php echo $this->get_field_id('nav_menu')?>" name="<?php echo $this->get_field_name('nav_menu')?>">
        <option value="">&mdash; <?php _e('Pages', 'sassy')?> &mdash;</option>
        <?php
        foreach ( $menus as $menu ) {
          echo '<option value="' . $menu->term_id . '"'
            . selected( $instance['nav_menu'], $menu->term_id, false )
            . '>'. esc_html( $menu->name ) . '</option>';
        }
        ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('depth')?>"><?php _e('Depth:', 'sassy')?></label>
      <input type="text" size="5" id="<?php echo $this->get_field_id('depth')?>" name="<?php echo $this->get_field_name('depth')?>" value="<?php echo esc_attr($instance['depth'])?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('variant')?>"><?php _e('Variant:', 'sassy')?></label>
      <select id="<?php echo $this->get_field_id('variant')?>" name="<?php echo $this->get_field_name('variant')?>">
        <option value=""><?php _e('Simple', 'sassy')?></option>
        <option value="horizontal-simple-menu" <?php selected($instance['variant'], 'horizontal-simple-menu')?>><?php _e('Simple horizontal ', 'sassy')?></option>
        <option value="horizontal-menu" <?php selected($instance['variant'], 'horizontal-menu')?>><?php _e('Horizontal', 'sassy')?></option>
        <option value="vertical-menu" <?php selected($instance['variant'], 'vertical-menu')?>><?php _e('Vertical', 'sassy')?></option>
        <option value="vertical-menu-tree" <?php selected($instance['variant'], 'vertical-menu-tree')?>><?php _e('Vertical tree', 'sassy')?></option>
        <option value="vertical-menu-accordion" <?php selected($instance['variant'], 'vertical-menu-accordion')?>><?php _e('Accordion', 'sassy')?></option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('responsive_variant')?>"><?php _e('Responsive variant:', 'sassy')?></label>
      <select id="<?php echo $this->get_field_id('responsive_variant')?>" name="<?php echo $this->get_field_name('responsive_variant')?>">
        <option value="responsive-none-menu"><?php _e('None', 'sassy')?></option>
        <option value="responsive-popup-menu" <?php selected($instance['responsive_variant'], 'responsive-popup-menu')?>><?php _e('Popup', 'sassy')?></option>
        <option value="responsive-dropdown-menu" <?php selected($instance['responsive_variant'], 'responsive-dropdown-menu')?>><?php _e('Dropdown', 'sassy')?></option>
        <option value="responsive-hamburger-menu" <?php selected($instance['responsive_variant'], 'responsive-hamburger-menu')?>><?php _e('Hamburger', 'sassy')?></option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('color')?>">
        <?php _e('Use theme main color', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('color')?>" name="<?php echo $this->get_field_name('color')?>" type="checkbox" value="1" <?php checked(!empty($instance['color']), TRUE)?> />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('show_description')?>">
        <?php _e('Show items description', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('show_description')?>" name="<?php echo $this->get_field_name('show_description')?>" type="checkbox" value="1" <?php checked(!empty($instance['show_description']), TRUE)?> />
    </p>
  <?php
  }
}


/**
 * Class SASSY_Widget_Login_Form
 */
class SASSY_Widget_Login_Form extends WP_Widget {

  function __construct() {
    parent::__construct(FALSE, __('(sassy) Login Form', 'sassy'));
  }

  function form($instance) {
    $instance = wp_parse_args($instance, array('title' => ''));

    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title')?>">
        <?php _e('Title:', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('hide_on_logged')?>">
        <?php _e('Hide when logged in', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('hide_on_logged')?>" name="<?php echo $this->get_field_name('hide_on_logged')?>" type="checkbox" value="1" <?php checked(!empty($instance['hide_on_logged']), TRUE)?> />
    </p>
    <?php

  }

  function widget($args, $instance) {

    if (is_user_logged_in() && !empty($instance['hide_on_logged'])) {
      return;
    }

    $instance = wp_parse_args($instance, array('title' => ''));

    echo $args['before_widget'];

    $instance['title'] = apply_filters('widget_title', $instance['title']);
    if ($instance['title']) {
      echo $args['before_title'] . $instance['title'] . $args['after_title'];
    }

    $form_args = array(
      'echo'           => true,
      'redirect'       => site_url($_SERVER['REQUEST_URI']),
      'form_id'        => 'loginform',
      'id_username'    => 'user_login',
      'id_password'    => 'user_pass',
      'id_remember'    => 'rememberme',
      'id_submit'      => 'wp-submit',
      'remember'       => TRUE,
      'value_username' => NULL,
      'value_remember' => FALSE,
    );
    echo wp_login_form($form_args);

    echo $args['after_widget'];
  }
}


/**
 * Widget content element
 *
 * TODO: suggest improvements to siteorigin panels content widget.
 */
class SASSY_Widget_Content_Element extends WP_Widget {


  function __construct() {
    parent::__construct(false, __('(sassy) Post Content Element', 'sassy'), array('description' => __('Display various content elements from the current viewed post.', 'sassy')));
  }

  function form($instance) {

    static $jsfndelta = 0;
    $jsfndelta++;
    $instance = wp_parse_args($instance, array(
      'title' => '',
      'element' => '',
      'noresult' => '',
      'rewrite' => '',
    ));
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title')?>">
        <?php _e('Title:', 'sassy')?>
      </label>
      <input id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" />
    </p>
    <p class="description">
      <small><?php _e('Different element formatters could act with the title, use %title tag to do that.', 'sassy')?></small>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('element')?>"><?php _e('Element:', 'sassy')?></label>
      <select onchange="sassyThemeContentWidgetOnChange<?php echo $jsfndelta?>(this)" id="<?php echo $this->get_field_id('element')?>" name="<?php echo $this->get_field_name('element')?>">
        <?php foreach ($this->content_elements() as $element_name => $element_data):?>
          <option <?php selected($instance['element'], $element_name)?> value="<?php echo esc_attr($element_name)?>">
            <?php echo $element_data['label']?>
          </option>
        <?php endforeach?>
      </select>
      <script>
        /**
         * Need this as separate function as it could be independant of document.ready state.
         */
        function sassyThemeContentWidgetOnChange<?php echo $jsfndelta?>(el) {
          jQuery('.<?php echo $this->get_field_id('element-settings')?>').slideUp(100);
          jQuery('#<?php echo $this->get_field_id('element-settings')?>-' + jQuery(el).val()).slideDown(100);
        }
      </script>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('hide_wrappers')?>">
        <input id="<?php echo $this->get_field_id('hide_wrappers')?>" name="<?php echo $this->get_field_name('hide_wrappers')?>" type="checkbox" value="1" <?php checked(!empty($instance['hide_wrappers']), TRUE)?> />
        <?php _e('Hide default HTML wrappers', 'sassy')?>
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('hide_on_empty')?>">
        <input id="<?php echo $this->get_field_id('hide_on_empty')?>" name="<?php echo $this->get_field_name('hide_on_empty')?>" type="checkbox" value="1" <?php checked(!empty($instance['hide_on_empty']), TRUE)?> />
        <?php _e('Hide widget when empty', 'sassy')?>
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('link_to_post')?>">
        <input id="<?php echo $this->get_field_id('link_to_post')?>" name="<?php echo $this->get_field_name('link_to_post')?>" type="checkbox" value="1" <?php checked(!empty($instance['link_to_post']), TRUE)?> />
        <?php _e('Link this item to the post', 'sassy')?>
      </label>
    </p>

    <div>
    <?php foreach ($this->content_elements() as $element_name => $element_data):?>

      <?php if (!empty($element_data['settings'])):?>
        <fieldset class="<?php echo $this->get_field_id('element-settings')?>" id="<?php echo $this->get_field_id('element-settings')?>-<?php echo esc_attr($element_name)?>"
                  <?php if ($instance['element'] != $element_name):?>
                  style="display:none;"
                  <?php endif?>
                  >
          <?php foreach ($element_data['settings'] as $setting_name => $setting_label):?>
            <p>
              <label for="<?php echo $this->get_field_id('element_settings_' . $element_name . '_' . $setting_name)?>">
                <?php echo $setting_label?>
              </label>
              <input id="<?php echo $this->get_field_id('element_settings_' . $element_name . '_' . $setting_name)?>"
                     name="<?php echo $this->get_field_name('element_settings')?>[<?php echo $element_name?>][<?php echo $setting_name?>]"
                     type="text" value="<?php echo empty($instance['element_settings'][$element_name][$setting_name]) ? '' : esc_attr($instance['element_settings'][$element_name][$setting_name])?>" />
            </p>
          <?php endforeach?>
        </fieldset>
      <?php endif?>

    <?php endforeach?>
    </div>

    <p>
      <label for="<?php echo $this->get_field_id('rewrite')?>">
        <?php _e('Rewrite content:', 'sassy')?>
      </label>
    </p>
    <p>
      <textarea style="width:98%" id="<?php echo $this->get_field_id('rewrite')?>" name="<?php echo $this->get_field_name('rewrite')?>"><?php echo esc_html($instance['rewrite'])?></textarea>
    </p>
    <p class="description">
      <small><?php _e('Custom content to rewrite the value (supported variable tags %value, %value_plain_text, %title, %post_url). <strong>HTML tags are supported.</strong>', 'sassy')?></small>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('noresult')?>">
        <?php _e('No result value:', 'sassy')?>
      </label>
    </p>
    <p>
      <textarea style="width:98%" id="<?php echo $this->get_field_id('noresult')?>" name="<?php echo $this->get_field_name('noresult')?>"><?php echo esc_html($instance['noresult'])?></textarea>
    </p>

  <?php
  }

  function widget($args, $instance) {

    $instance = wp_parse_args($instance, array(
      'title' => '',
      'element' => '',
      'noresult' => '',
      'rewrite' => '',
    ));

    global $post;

    if (!$post) {
      return;
    }

    $elements = $this->content_elements();

    if (!$instance['element'] || empty($elements[$instance['element']]['callback'])) {
      return;
    }

    ob_start();
    $callback_args = array();

    if (!empty($elements[$instance['element']]['args'])) {
      $callback_args = array_merge($callback_args, $elements[$instance['element']]['args']);
    }

    if (!empty($elements[$instance['element']]['settings'])) {
      if (empty($instance['element_settings'][$instance['element']])) {
        $instance['element_settings'][$instance['element']] = array();
      }
      $elements[$instance['element']]['settings'] = array_merge($elements[$instance['element']]['settings'], $instance['element_settings'][$instance['element']]);
      $callback_args = array_merge($callback_args, $elements[$instance['element']]['settings']);
    }

    $result = call_user_func($elements[$instance['element']]['callback'], $callback_args, $instance);
    if (!is_array($result)) {
      $result = array();
    }
    foreach ($result as $key => $val) {
      $result['%' . $key] = $val;
    }
    $result['%value'] = ob_get_clean();
    $result['%value_plain_text'] = strip_tags($result['%value']);
    $result['%post_url'] = esc_attr(get_the_permalink($post));


    if (!empty($instance['hide_on_empty']) && !$result['%value']) {
      return;
    }

    if (!$result['%value']) {
      $result['%value'] = $instance['noresult'];
    }

    if ($instance['rewrite']) {
      $result['%value'] = strtr($instance['rewrite'], $result);
    }

    if (empty($instance['hide_wrappers'])) {
      echo $args['before_widget'];
    }

    $instance['title'] = strtr($instance['title'], $result);

    $instance['title'] = apply_filters('widget_title', $instance['title']);
    if ($instance['title']) {
      echo $args['before_title'] . $instance['title'] . $args['after_title'];
    }

    if (!empty($instance['link_to_post'])) {
      // If there is link, use it.
      $pattern = '/<a(.*)href=(")?([a-zA-Z]+)"? ?(.*)>(.*)<\/a>/i';
      if (preg_match($pattern, $result['%value'])) {
        echo preg_replace($pattern, get_the_permalink($post), $result['%value']);
      }
      // Otherwise wrap to new link.
      else {
        echo '<a href="' . esc_attr(get_the_permalink($post)) . '">' . $result['%value'] . '</a>';
      }
    }
    else {
      echo $result['%value'];
    }

    if (empty($instance['hide_wrappers'])) {
      echo $args['after_widget'];
    }
  }


  /**
   * Supported element formatters of the widget
   *
   * @return array
   */
  function content_elements() {

    // Try save some time with simple caching of $elements
    static $elements = NULL;

    if ($elements !== NULL) {
      return $elements;
    }

    $elements = array(
      'custom' => array(
        'callback' => array($this, 'formatter_custom'),
        'label' => __('Empty', 'sassy'),
      ),
      'post_title' => array(
        'callback' => array($this, 'formatter_title'),
        'label' => __('Title', 'sassy'),
      ),
      'post_thumbnail' => array(
        'callback' => array($this, 'formatter_post_thumbnail'),
        'label' => __('Thumbnail', 'sassy'),
        'settings' => array(
          'size' => __('Size string or dimensions', 'sassy'),
        ),
      ),
      'post_meta' => array(
        'callback' => array($this, 'formatter_post_meta'),
        'label' => __('Meta', 'sassy'),
      ),
      'post_excerpt' => array(
        'callback' => array($this, 'formatter_excerpt'),
        'label' => __('Excerpt', 'sassy'),
      ),
      'post_content' => array(
        'callback' => array($this, 'formatter_content'),
        'label' => __('Content', 'sassy'),
      ),
      'comments_block' => array(
        'callback' => array($this, 'formatter_comments_block'),
        'label' => __('Comments block', 'sassy'),
      ),
      'post_author_bio' => array(
        'label' => __('Post author bio', 'sassy'),
        'callback' => array($this, 'formatter_post_author_bio'),
      ),
    );

    $elements['post_custom_fields'] = array(
      'label' => __('Custom post meta field', 'sassy'),
      'callback' => array($this, 'formatter_post_custom_field'),
      'settings' => array(
        'post_field_name' => __('Field name', 'sassy'),
        'post_field_label' => __('Override label', 'sassy'),
      ),
    );

    foreach (get_taxonomies(array('public' => TRUE)) as $taxonomy) {
      $elements['taxonomy-' . $taxonomy] = array(
        'label' => sprintf(__('Taxonomy - %s', 'sassy'), $taxonomy),
        'callback' => array($this, 'formatter_taxonomy'),
        'args' => array('taxonomy' => $taxonomy),
      );
    }

    $elements = apply_filters('sassy_widget_content_element_elements', $elements);

    return $elements;
  }


  /**
   * Title formatter.
   */
  function formatter_custom($args) {
    // null;
  }

  /**
   * Title formatter.
   */
  function formatter_title() {
    if (!get_the_title()) {
      return;
    }

    if (is_singular() || in_the_loop()) {
      if (defined('WOOCOMMERCE_VERSION') && is_woocommerce() && is_product()) {
        woocommerce_template_single_title();
      }
      else {
        ?>
        <h1 class="entry-header-title">
          <?php the_title() ?>
        </h1>
        <?php
      }
    }
    else {
      ?>
      <h1 class="entry-header-title">
        <?php
          if (defined('WOOCOMMERCE_VERSION') && is_woocommerce()) {
            woocommerce_page_title();
          }
          else {
            post_type_archive_title();
          }
        ?>
      </h1>
      <?php
    }
  }

  /**
   * Post thumbnail
   */
  function formatter_post_thumbnail($args) {
    if (has_post_thumbnail()) {
      $size = (is_single() ? 'large' : 'medium');
      if  (!empty($args['size'])) {
        if (strpos($args['size'], ',')) {
          $size = explode(',', $size);
        }
        else {
          $size = $args['size'];
        }
      }
      ?>
      <div class="entry-thumbnail-wrapper">
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute()?>">
          <?php the_post_thumbnail($size, 'class=thumbnail')?>
        </a>
      </div>
    <?php
    }
  }


  /**
   * Excerpt formatter.
   */
  function formatter_excerpt() {
    if (get_the_excerpt()) {
      ?>
      <div class="entry-summary teaser">
        <?php the_excerpt()?>
      </div>
      <?php
    }
  }

  /**
   * Meta formatter.
   */
  function formatter_post_meta() {
    ?>
    <div class="entry-header-meta">
      <time class="entry-header-meta-time" datetime="<?php the_time('c')?>" pubdate="pubdate">
        <?php the_time(get_option('date_format'))?>
      </time>
      <span class="entry-header-meta-comments">
        <?php comments_number('0', '1', '%')?>
      </span>
      <span class="entry-header-meta-author">
        <?php the_author()?>
      </span>
    </div>
    <?php
  }

  /**
   * Taxonomy formatter.
   */
  function formatter_taxonomy($args) {
    if ($terms = get_the_terms(get_the_ID(), $args['taxonomy'])) {
      ?>
      <div class="field-taxonomy-terms">
        <?php foreach ($terms as $term): ?>
          <a rel="nofollow" href="<?php echo get_term_link($term) ?>"
             title="<?php echo $term->name ?>"
             class="taxonomy-term-<?php echo $term->term_id ?>">
            <?php echo $term->name ?>
          </a>
        <?php endforeach ?>
      </div>
      <?php
    }
  }

  /**
   * Custom post field formatter.
   */
  function formatter_post_custom_field($args, $instance) {
    if (!empty($args['post_field_name'])) {
      return;
    }
    $post_meta = get_post_meta(get_the_ID(), $args['post_field_name'], FALSE);
    if (empty($post_meta)) {
      return;
    }
    ?>
    <div class="post-custom-meta-field post-custom-meta-field-<?php echo esc_attr($args['post_field_name'])?>">
      <span class="post-custom-meta-label"> <?php echo ($args['post_field_label'] ? $args['post_field_label'] : $args['post_field_name'])?> </span>
      <span class="post-custom-meta-value"> <?php echo implode(', ', $post_meta)?> </span>
    </div>
    <?php
  }

  /**
   * Content formatter.
   */
  function formatter_content() {
    if (get_the_content()) {
      ?>
      <div class="entry-content">
        <?php
          the_content();
          sassy_pagination('singular');
        ?>
      </div>
      <?php
    }
  }

  /**
   * Comments block
   */
  function formatter_comments_block() {
    $result = array();
    $result['title'] = get_comments_number_text();
    global $sassy_hide_comments_title;
    $sassy_hide_comments_title = TRUE;
    comments_template();
    $sassy_hide_comments_title = FALSE;
    return $result;
  }

  /**
   * Post author bio
   */
  function formatter_post_author_bio() {
    get_template_part('templates/author-bio');
  }

}
