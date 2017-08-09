<?php

/**
 * @file
 * Main WooCommerce integration file
 */



/**
 * Include other files.
 */
require __DIR__ . '/functions.php';


/**
 * Class SassyWooCommerce
 */
class SassyWooCommerce {


  function __construct() {

    add_filter('sassy_theme_settings', array($this, 'sassy_theme_settings'));

    add_action('after_setup_theme', array($this, 'setup'));
    add_action('wp_loaded', array($this, 'wp_loaded'));

    add_filter('sassy_scss_settings', array($this, 'sassy_scss_settings'));

    if (defined('SITEORIGIN_PANELS_VERSION')) {
      // Dirty workaround for https://wordpress.org/support/topic/is_active_widget-return-false
      add_filter('sidebars_widgets', array($this, 'simulate_active_widgets'), SASSY_HOOK_LAST_PNUM);
    }

  }

  /**
   * Main setup
   */
  function setup() {

    add_theme_support('woocommerce');

    add_action('customize_register' , array($this , 'customizer_register'));
    add_action('sassy_ajax_woocommerce', 'sassy_ajax_woocommerce');
    add_action('widgets_init', array($this, 'widgets_init'));

    add_filter('sassy_widget_content_element_elements', array($this, 'sassy_widget_content_element_elements'));
    add_filter('sassy_compute_rule_tag', array($this, 'sassy_compute_rule_tag'), 10, 3);
    add_filter('sassy_layout_selection_rule_skip_types', array($this, 'sassy_layout_selection_rule_skip_types'));
    do_action('sassy_woocommerce_after_setup');
  }


  /**
   * WP Is loaded
   */
  function wp_loaded() {

    add_action('wp', array($this, 'setup_templates'));
    add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'), 101);

    add_action('product_cat_add_form_fields', array($this, 'add_category_fields'));
    add_action('product_cat_edit_form_fields', array($this, 'edit_category_fields'), 10, 2);
    add_action('created_term', array($this, 'save_category_fields'), 10, 3);
    add_action('edit_term', array($this, 'save_category_fields'), 10, 3);

    add_filter('loop_shop_per_page', array($this, 'loop_shop_per_page'));
    add_filter('loop_shop_columns', array($this, 'loop_shop_columns'));
    add_filter('woocommerce_enqueue_styles', '__return_false' );

    if ( defined('WC_VERSION') && version_compare( WC_VERSION, '2.3', '>=' ) ) {
      add_filter('woocommerce_add_to_cart_fragments', array($this, 'cart_link_fragment'));
    }
    else {
      add_filter('add_to_cart_fragments', array($this, 'cart_link_fragment'));
    }

    add_filter('sassy_user_profile_url', array($this, 'sassy_user_profile_url'));

  }


  /**
   * Perform theme ajax actions
   */
  function sassy_ajax_woocommerce() {

    if (!empty($_REQUEST['product-action'])) {

      // Product get wishlist.
      if ($_REQUEST['product-action'] == 'product-wishlist' && !empty($_REQUEST['product'])) {
        return sassy_wishlist_rating($_REQUEST['product']);
      }

      // User wishlist per product.
      elseif (in_array($_REQUEST['product-action'], array('wishlist-add', 'wishlist-remove', 'wishlist-has')) && wp_get_current_user()->ID && !empty($_REQUEST['product'])) {
        if ($_REQUEST['product-action'] == 'wishlist-add') {
          return sassy_user_wishlist_add(wp_get_current_user()->ID, $_REQUEST['product']);
        }
        elseif ($_REQUEST['product-action'] == 'wishlist-remove') {
          return sassy_user_wishlist_remove(wp_get_current_user()->ID, $_REQUEST['product']);
        }
        elseif ($_REQUEST['product-action'] == 'wishlist-has') {
          return sassy_user_wishlist_has(wp_get_current_user()->ID, $_REQUEST['product']);
        }
      }

      // User wishlist
      elseif ($_REQUEST['product-action'] == 'user-wishlists' && wp_get_current_user()->ID) {
        return sassy_user_wishlist_get(wp_get_current_user()->ID, TRUE);
      }
    }

  }

  /**
   * Because WooCommerce load Widget's assets if widget is active,
   * we need to cheat about it.
   *
   * @param $active_widgets
   *
   * @return mixed
   */
  function simulate_active_widgets($active_widgets) {
    $active_widgets['_siteorigin_panels'] = array(
      'woocommerce_top_rated_products-0',
      'woocommerce_widget_cart-0',
      'woocommerce_layered_nav-0',
      'woocommerce_price_filter-0',
      'woocommerce_product_categories-0',
      'woocommerce_product_tag_cloud-0',
      'woocommerce_product_search-0',
      'woocommerce_products-0',
      'woocommerce_recent_reviews-0',
      'woocommerce_recently_viewed_products-0',
    );
    return $active_widgets;
  }


  /**
   * Registering theme WooCommerce widgets.
   */
  function widgets_init() {
    register_widget('SASSY_Widget_WooCommerce_Wishlist');
  }


  /**
   * Override user profile URL
   */
  function sassy_user_profile_url($link) {
    return get_permalink( get_option('woocommerce_myaccount_page_id') );
  }


  /**
   * Let sass know that we have woocommerce
   */
  function sassy_scss_settings($options) {
    $options['supports_woocommerce'] = 1;
    return $options;
  }

  
  /**
   * Cart fragment
   */
  function cart_link_fragment($fragments) {
    ob_start();
    sassy_woocommerce_cart_link_fragment();
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
  }

  
  /**
   * Tweak WooCommerce templates.
   */
  function setup_templates() {
    // Templating
    remove_all_actions( 'woocommerce_before_main_content');
    remove_all_actions('woocommerce_after_main_content');

    // Wrap as browser tools ordering and counts.
    if (is_singular()) {
      $this->setup_templates_singular();
    }
    else {
      $this->setup_templates_archive();
    }

  }

  /**
   * WooCommerce Product Catalog Pages and views
   */
  function setup_templates_archive() {

    // Theme depends on these wrappers
    add_action('woocommerce_before_main_content', function() { echo '<div class="site-content-entries">'; }, 1);
    add_action('woocommerce_before_shop_loop', function() { echo '<div class="archive-product-browser-tools">'; }, 3);
    add_action('woocommerce_before_shop_loop', function() { echo '</div>'; }, SASSY_HOOK_LAST_PNUM);
    add_action('woocommerce_after_main_content', function() { echo '</div>'; }, SASSY_HOOK_LAST_PNUM);

    if (SassySettings::get('woocommerce_products_show_cat_title') != '') {
      add_filter('woocommerce_show_page_title', '__return_false', SASSY_HOOK_LAST_PNUM);
      remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
      remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
    }

    add_action('woocommerce_before_main_content', function() {
      if (SassySettings::get('woocommerce_products_show_cat_title') == 'outside') {
        echo '<h1 class="page-title">' . woocommerce_page_title(FALSE) . '</h1>';
        woocommerce_taxonomy_archive_description();
        woocommerce_product_archive_description();
      }
    }, 0);

    // Add category header image.
    add_action('woocommerce_before_main_content', function() {

      echo '<div class="products-category-header">';

      $cathasimage_class = '-without-image';

      if ( is_product_category() ) {
        $term = get_queried_object();
        $header_image_id = get_woocommerce_term_meta($term->term_id, 'header_image_id', TRUE);
        if ($header_image_id) {
          $cathasimage_class = '-with-image';
          echo wp_get_attachment_image($header_image_id, 'large', FALSE, 'class=header-image');
        }
      }

      if (SassySettings::get('woocommerce_products_show_cat_title') == 'inheader') {
        echo '<div class="title-wrapper products-category-header' . $cathasimage_class . '">';
        echo '<h1 class="page-title">' . woocommerce_page_title(FALSE) . '</h1>';
        woocommerce_taxonomy_archive_description();
        woocommerce_product_archive_description();
        echo '</div>';
      }

      echo '</div>';

    }, 2);

    // Sale position
    if (!SassySettings::get('woocommerce_products_sale_label')) {
      remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    }
    elseif (SassySettings::get('woocommerce_products_sale_label') == 'afterimage') {
      remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
      add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 0);
    }
    elseif (SassySettings::get('woocommerce_products_sale_label') == 'image') {
      remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
      add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 2);
    }

    // Show/hide ratings
    if (!SassySettings::get('woocommerce_products_show_rating')) {
      remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    }

    // Titles
    if (SassySettings::get('woocommerce_products_show_title') == 'beforeimage') {
      remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
      add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 0);
    }

    // Show/hide price
    if (!SassySettings::get('woocommerce_products_show_price')) {
      remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
    }

    // Move add to cart button after the image.
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    if (SassySettings::get('woocommerce_products_show_add_to_cart') != 'hidden') {
      add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 4);
    }

  }


  /**
   * WooCommerce Product Page
   */
  function setup_templates_singular() {

    add_action('woocommerce_before_shop_loop', function() { echo '<div class="site-content-entries">'; }, 1);
    add_action('woocommerce_after_shop_loop', function() { echo '</div>'; }, SASSY_HOOK_LAST_PNUM);


    add_action('woocommerce_before_single_product_summary', function() {
      echo '<div class="product-view-info">';
    }, 4);
    add_action('woocommerce_after_single_product_summary', function() {
      echo '</div>';
    }, 4);

    // Sale label woocommerce_product_sale_label
    if (SassySettings::get('woocommerce_product_sale_label') == '') {
      remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
    }
    elseif (SassySettings::get('woocommerce_product_sale_label') == 'title') {
      remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
      add_action('woocommerce_after_template_part', function($template_name, $template_path, $located, $args) {
        if ($template_name == 'single-product/title.php') {
          woocommerce_show_product_sale_flash();
        }
      }, 10, 4);
    }
    elseif (SassySettings::get('woocommerce_product_sale_label') == 'teaser') {
      remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
      add_action('woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 7);
    }

    // Titles
    if (SassySettings::get('woocommerce_product_show_title') == 'hidden') {
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    }
    elseif (SassySettings::get('woocommerce_product_show_title') == 'beforeimage') {
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
      add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 3);
    }
    if (SassySettings::get('woocommerce_product_show_title') == 'overimage') {
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
      add_filter('woocommerce_single_product_image_html', function($markup) {
        ob_start();
        woocommerce_template_single_title();
        return ob_get_clean() . $markup;
      }, 10);
    }

    // Prices
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 6);

    // Rearange meta data.
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    if (SassySettings::get('woocommerce_product_show_meta')) {
      add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 9);
    }

    // Ratings
    if (!SassySettings::get('woocommerce_product_show_ratings')) {
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    }

    // Lowest shiping price and custom html
    add_action('woocommerce_single_product_summary', array($this, 'woocommerce_single_product_summary'), 10);

    // Teaser
    if (!SassySettings::get('woocommerce_product_show_teaser')) {
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    }

    // Remove thumbnails from product body
    if (SassySettings::get('woocommerce_product_images_position') == 'tabs') {
      remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
    }
    add_filter('woocommerce_product_tabs', array($this, 'woocommerce_product_tabs'), 20);


    // Disable headins
    add_filter('woocommerce_product_additional_information_heading', '__return_null', SASSY_HOOK_LAST_PNUM);
    add_filter('woocommerce_product_description_heading', '__return_null', SASSY_HOOK_LAST_PNUM);

    // Fix Jetpack sharing position
    if (function_exists('sharing_display')) {
      remove_filter('the_content', 'sharing_display', 19);
      remove_filter('the_excerpt', 'sharing_display', 19);
      add_action('woocommerce_share', function () {
        sharing_display('', TRUE);
      }, 11);
    }
  }
  

  /**
   * Product summary come from theme
   */
  function woocommerce_single_product_summary() {
    global $post, $product;

    // Add wishlist placeholders.
    if (SassySettings::get('woocommerce_product_wishlist')) {
      printf('<div class="product-wishlist-actions" data-post-id="%s" data-label-add="%s" data-label-status="%s" data-label-remove="%s"></div>',
        $post->ID,
        esc_attr(__('Add to wishlist', 'sassy')),
        esc_attr(__('In your wishlist', 'sassy')),
        esc_attr(__('Remove from wishlist', 'sassy')));
    }

    // Insert custom html in product teaser
    if (SassySettings::get('woocommerce_product_custom_html')) {
      echo '<div class="custom-html">' . SassySettings::get('woocommerce_product_custom_html') . '</div>';
    }

    // Lowest shipping price
    if (SassySettings::get('woocommerce_product_show_lowest_shipping_price')) {
      if (!$product->is_virtual() && $product->is_purchasable() && ($lowest_shiping_price = sassy_woocommerce_lowest_shipping_price()) !== NULL) {
        if ($lowest_shiping_price) {
          echo '<div class="lowest-shipping-price">' . sprintf(__('Shipping from: %s', 'sassy'), wc_price($lowest_shiping_price)) . '</div>';
        }
      }
    }

  }


  /**
   * Alter product Tabs
   */
  function woocommerce_product_tabs($tabs) {
    global $post, $product;

    // Move reviews tab to the end of tabs
    $tabs['reviews']['priority'] = 80;

    // Move thumbnails as separated tab
    if (SassySettings::get('woocommerce_product_images_position') == 'tabs') {
      $tabs['photos'] = array(
        'title' => __('Images', 'sassy'),
        'priority' => 40,
        'callback' => function() {
          $__sassy_return_shop_single = function() {
            return 'shop_single';
          };
          add_filter('single_product_small_thumbnail_size', $__sassy_return_shop_single, SASSY_HOOK_LAST_PNUM);
          woocommerce_show_product_thumbnails();
          remove_filter('single_product_small_thumbnail_size', $__sassy_return_shop_single, SASSY_HOOK_LAST_PNUM);
        },
      );
    }
    return $tabs;
  }


  /**
   * Add JS to the theme
   */
  function wp_enqueue_scripts() {
    wp_enqueue_script('sassy-woocommerce', get_template_directory_uri() . '/assets/js/woocommerce.js', array('sassy'), NULL, TRUE);
  }


  /**
   * Override products per page num
   */
  function loop_shop_per_page($num) {
    return SassySettings::get('woocommerce_products_per_page', $num);
  }


  /**
   * Override products per row
   */
  function loop_shop_columns($num) {
    return SassySettings::get('woocommerce_products_per_row', $num);
  }


  /**
   * Add new customizer component sections
   */
  function customizer_register(WP_Customize_Manager $wp_customize) {
    $wp_customize->add_section('woocommerce-products', array(
      'title' => __('WooCommerce Products catalog', 'woocommerce'),
      'panel' => 'components',
    ));
    $wp_customize->add_section('woocommerce-product', array(
      'title' => __('WooCommerce Product view', 'woocommerce'),
      'panel' => 'components',
    ));
  }


  /**
   * Add theme options for woocommerce
   */
  function sassy_theme_settings($options) {

    /**
     * Product archives
     */
    $options['woocommerce_products_per_page'] = array(
      'label' => __('Products per page in catalog', 'sassy'),
      'type' => 'select',
      'default' => 30,
      'choices' => array(
        8 => 8,
        12 => 12,
        16 => 16,
        25 => 25,
        28 => 28,
        30 => 30,
        36 => 36,
        40 => 40,
        48 => 48,
        72 => 72,
        114 => 114,
        228 => 228,
        0 => __('All', 'sassy'),
      ),
      'section' => 'woocommerce-products',
    );
    $options['woocommerce_products_per_row'] = array(
      'section' => 'woocommerce-products',
      'label' => __('Products per row in catalog', 'sassy'),
      'type' => 'number',
      'default' => 4,
      'input_attrs' => array(
        'min'   => 2,
        'max'   => 6,
        'step'  => 1,
        'style' => 'width:4em;',
      ),
      'export_scss' => TRUE,
    );
    $options['woocommerce_products_show_cat_title'] = array(
      'label' => __('Show category title and description', 'sassy'),
      'type' => 'select',
      'default' => '',
      'choices' => array(
        'hidden' => __('Hidden', 'sassy'),
        '' => __('Default', 'sassy'),
        'outside' => __('Outside', 'sassy'),
        'inheader' => __('In header', 'sassy'),
      ),
      'export_scss' => TRUE,
      'section' => 'woocommerce-products',
    );
    $options['woocommerce_products_show_title'] = array(
      'label' => __('Show title and category titles', 'sassy'),
      'type' => 'select',
      'default' => '',
      'choices' => array(
        'hidden' => __('Hidden', 'sassy'),
        '' => __('Default', 'sassy'),
        'beforeimage' => __('Before image', 'sassy'),
      ),
      'export_scss' => TRUE,
      'section' => 'woocommerce-products',
    );
    $options['woocommerce_products_show_border'] = array(
      'label' => __('Show product border', 'sassy'),
      'type' => 'select',
      'choices' => array(
        '' => __('None', 'sassy'),
        'neutral' => __('Neutral theme color (inactive)', 'sassy'),
        'active' => __('Theme color - primary', 'sassy'),
        'hover_only' => __('Only on hover', 'sassy'),
      ),
      'default' => '',
      'section' => 'woocommerce-products',
      'export_scss' => TRUE,
    );
    $options['woocommerce_products_show_rating'] = array(
      'label' => __('Show ratings in product catalog', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'section' => 'woocommerce-products',
    );
    $options['woocommerce_products_show_price'] = array(
      'label' => __('Show prices in product catalog', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'section' => 'woocommerce-products',
    );
    $options['woocommerce_products_sale_label'] = array(
      'label' => __('Sale label position', 'sassy'),
      'type' => 'select',
      'default' => 'image',
      'choices' => array(
        '' => __('Hidden', 'sassy'),
        'image' => __('Over image', 'sassy'),
        'afterimage' => __('After image', 'sassy'),
        'topcorner' => __('Top corner', 'sassy'),
      ),
      'export_scss' => TRUE,
      'section' => 'woocommerce-products',
    );
    $options['woocommerce_products_show_add_to_cart'] = array(
      'label' => __('Show add to cart button in product catalog', 'sassy'),
      'type' => 'select',
      'choices' => array(
        'hidden' => __('Hidden', 'sassy'),
        '' => __('Button', 'sassy'),
        'hover' => __('Hover', 'sassy'),
        'corner' => __('Corner', 'sassy'),
      ),
      'default' => '',
      'section' => 'woocommerce-products',
      'export_scss' => TRUE,
    );


    /**
     * Single product view options
     */
    $options['woocommerce_product_show_title'] = array(
      'label' => __('Show products title', 'sassy'),
      'type' => 'select',
      'default' => '',
      'choices' => array(
        '' => __('Default', 'sassy'),
        'hidden' => __('Hidden', 'sassy'),
        'beforeimage' => __('Before product image', 'sassy'),
        'overimage' => __('Over image', 'sassy'),
      ),
      'export_scss' => TRUE,
      'section' => 'woocommerce-product',
    );
    $options['woocommerce_product_sale_label'] = array(
      'label' => __('Sale label position', 'sassy'),
      'type' => 'select',
      'default' => 'image',
      'choices' => array(
        '' => __('Hidden', 'sassy'),
        'title' => __('After title', 'sassy'),
        'image' => __('Over image', 'sassy'),
        'teaser' => __('In teaser', 'sassy'),
      ),
      'export_scss' => TRUE,
      'section' => 'woocommerce-product',
    );
    $options['woocommerce_product_show_teaser'] = array(
      'label' => __('Show teaser in product views', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'section' => 'woocommerce-product',
    );
    $options['woocommerce_product_show_ratings'] = array(
      'label' => __('Show ratings in product views', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'section' => 'woocommerce-product',
    );
    $options['woocommerce_product_show_meta'] = array(
      'label' => __('Show product meta info', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'section' => 'woocommerce-product',
      'export_scss' => TRUE,
    );
    $options['woocommerce_product_wishlist'] = array(
      'label' => __('Show wishlist actions', 'sassy'),
      'type' => 'checkbox',
      'default' => FALSE,
      'section' => 'woocommerce-product',
      'export_js' => TRUE,
    );
    $options['woocommerce_product_custom_html'] = array(
      'label' => __('Insert custom HTML', 'sassy'),
      'type' => 'textarea',
      'default' => '',
      'section' => 'woocommerce-product',
    );
    $options['woocommerce_product_show_lowest_shipping_price'] = array(
      'label' => __('Show lowest shiping price', 'sassy'),
      'type' => 'checkbox',
      'default' => FALSE,
      'section' => 'woocommerce-product',
      'export_scss' => TRUE,
    );
    $options['woocommerce_product_show_sku'] = array(
      'label' => __('Show SKU on products', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'section' => 'woocommerce-product',
      'export_scss' => TRUE,
    );
    $options['woocommerce_product_show_qty_selector'] = array(
      'label' => __('Show quantity selector', 'sassy'),
      'type' => 'checkbox',
      'default' => TRUE,
      'export_scss' => TRUE,
      'section' => 'woocommerce-product',
    );
    $options['woocommerce_product_images_position'] = array(
      'label' => __('Product thumbnails position', 'sassy'),
      'type' => 'select',
      'default' => '',
      'choices' => array(
        '' => __('Default', 'sassy'),
        'side' => __('Side', 'sassy'),
        'tabs' => __('Tabs', 'sassy'),
      ),
      'export_scss' => TRUE,
      'section' => 'woocommerce-product',
    );

    return $options;
  }



  /**
   * Category thumbnail fields.
   *
   * @access public
   * @return void
   */
  public function add_category_fields() {
    ?>
    <div class="form-field">
      <label><?php _e( 'Header Image', 'sassy')?></label>
      <div id="product_cat_header_image" style="float:left;margin-right:10px;"><img src="<?php echo wc_placeholder_img_src(); ?>" width="60px" height="60px" /></div>
      <div style="line-height:60px;">
        <input type="hidden" id="product_cat_header_image_id" name="product_cat_header_image" />
        <button type="button" class="product_cat_header_image_upload_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
        <button type="button" class="product_cat_header_image_remove_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
      </div>
      <script type="text/javascript">

        // Only show the "remove image" button when needed
        if ( ! jQuery('#product_cat_header_image_id').val() )
          jQuery('.product_cat_header_image_remove_image_button').hide();

        // Uploading files
        var file_frame;

        jQuery(document).on( 'click', '.product_cat_header_image_upload_image_button', function( event ){

          event.preventDefault();

          // If the media frame already exists, reopen it.
          if ( file_frame ) {
            file_frame.open();
            return;
          }

          // Create the media frame.
          file_frame = wp.media.frames.downloadable_file = wp.media({
            title: '<?php _e( 'Choose an image', 'woocommerce' ); ?>',
            button: {
              text: '<?php _e( 'Use image', 'woocommerce' ); ?>'
            },
            multiple: false
          });

          // When an image is selected, run a callback.
          file_frame.on( 'select', function() {
            attachment = file_frame.state().get('selection').first().toJSON();

            jQuery('#product_cat_header_image_id').val( attachment.id );
            jQuery('#product_cat_header_image img').attr('src', attachment.url );
            jQuery('.product_cat_header_image_remove_image_button').show();
          });

          // Finally, open the modal.
          file_frame.open();
        });

        jQuery(document).on( 'click', '.product_cat_header_image_remove_image_button', function( event ){
          jQuery('#product_cat_header_image img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
          jQuery('#product_cat_header_image_id').val('');
          jQuery('.product_cat_header_image_remove_image_button').hide();
          return false;
        });

      </script>
      <div class="clear"></div>
    </div>
  <?php
  }


  /**
   * Edit category thumbnail field.
   *
   * @access public
   * @param mixed $term Term (category) being edited
   * @param mixed $taxonomy Taxonomy of the term being edited
   */
  public function edit_category_fields( $term, $taxonomy ) {

    $image 			= '';
    $header_image_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'header_image_id', true ) );
    if ( $header_image_id )
      $image = wp_get_attachment_thumb_url( $header_image_id );
    else
      $image = wc_placeholder_img_src();
    ?>
    <tr class="form-field">
      <th scope="row" valign="top"><label><?php _e('Header Image', 'sassy')?></label></th>
      <td>
        <div id="product_cat_header_image" style="float:left;margin-right:10px;"><img src="<?php echo $image; ?>" width="60px" height="60px" /></div>
        <div style="line-height:60px;">
          <input type="hidden" id="product_cat_header_image_id" name="product_cat_header_image" value="<?php echo $header_image_id ? $header_image_id : ''?>" />
          <button type="button" class="product_cat_header_image_upload_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
          <button type="button" class="product_cat_header_image_remove_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
        </div>

        <script type="text/javascript">

          // Only show the "remove image" button when needed
          if ( ! jQuery('#product_cat_header_image_id').val() )
            jQuery('.product_cat_header_image_remove_image_button').hide();

          // Uploading files
          var file_frame;

          jQuery(document).on( 'click', '.product_cat_header_image_upload_image_button', function( event ){

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if ( file_frame ) {
              file_frame.open();
              return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.downloadable_file = wp.media({
              title: '<?php _e( 'Choose an image', 'woocommerce' ); ?>',
              button: {
                text: '<?php _e( 'Use image', 'woocommerce' ); ?>'
              },
              multiple: false
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
              attachment = file_frame.state().get('selection').first().toJSON();

              jQuery('#product_cat_header_image_id').val( attachment.id );
              jQuery('#product_cat_header_image img').attr('src', attachment.url );
              jQuery('.product_cat_header_image_remove_image_button').show();
            });

            // Finally, open the modal.
            file_frame.open();
          });

          jQuery(document).on( 'click', '.product_cat_header_image_remove_image_button', function( event ){
            jQuery('#product_cat_header_image img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
            jQuery('#product_cat_header_image_id').val('');
            jQuery('.product_cat_header_image_remove_image_button').hide();
            return false;
          });

        </script>
        <div class="clear"></div>
      </td>
    </tr>
  <?php
  }


  /**
   * save_category_fields function.
   *
   * @access public
   * @param mixed $term_id Term ID being saved
   * @param mixed $tt_id
   * @param mixed $taxonomy Taxonomy of the term being saved
   * @return void
   */
  public function save_category_fields($term_id, $tt_id, $taxonomy) {
    if ( isset( $_POST['product_cat_header_image'] ) ) {
      update_woocommerce_term_meta( $term_id, 'header_image_id', absint( $_POST['product_cat_header_image'] ) );
    }
  }


  /**
   * Attatch to singular product widget
   *
   * @param $elements
   *
   * @return array
   */
  function sassy_widget_content_element_elements($elements) {
    $elements['woocommerce_product_teaser'] = array(
      'label' => __('WooCommerce Product Teaser', 'sassy'),
      'callback' => array($this, 'sassy_widget_content_element_elements_product_teaser'),
    );
    $elements['woocommerce_product_teaser_image'] = array(
      'label' => __('WooCommerce Product Teaser: Images', 'sassy'),
      'callback' => array($this, 'sassy_widget_content_element_elements_product_teaser_image'),
    );
    $elements['woocommerce_product_teaser_info'] = array(
      'label' => __('WooCommerce Product Teaser: Info', 'sassy'),
      'callback' => array($this, 'sassy_widget_content_element_elements_product_teaser_info'),
    );
    $elements['woocommerce_product_related'] = array(
      'label' => __('WooCommerce Product Related', 'sassy'),
      'callback' => array($this, 'sassy_widget_content_element_elements_product_related'),
    );

    $elements['woocommerce_product_info'] = array(
      'label' => __('WooCommerce Product Tabs', 'sassy'),
      'callback' => array($this, 'sassy_widget_content_element_elements_product_info'),
    );
    $default_tabs = array(
      'photos' => array(
        'title' => __('Images', 'sassy'),
      ),
      'description' => array(
        'title' => __( 'Description', 'woocommerce' ),
      ),
      'additional_information' => array(
        'title' => __( 'Additional Information', 'woocommerce' ),
      ),
      'reviews' => array(
        'title' => __( 'Reviews', 'woocommerce' ),
      ),
    );
    // Not possibl right now because this hook is callend only on frontpages.
    // $default_tabs = apply_filters('woocommerce_product_tabs', $default_tabs);
    foreach ($default_tabs as $key => $tab) {
      $elements['woocommerce_product_tab_' . $key] = array(
        'label' => sprintf(__('WooCommerce Product Tab: %s', 'sassy'), $tab['title']),
        'callback' => array($this, 'sassy_widget_content_element_elements_product_tab'),
        'args' => array('title' => $tab['title'], 'tab' => $key),
      );
    }

    return $elements;
  }

  /**
   * Product teaser
   * @see woocommerce/templates/content-single-product.php
   */
  function sassy_widget_content_element_elements_product_teaser_image() {
    if (!is_product()) {
      return;
    }
    if (SassySettings::get('woocommerce_product_show_title') == 'beforeimage') {
      woocommerce_template_single_title();
    }
    ?>
    <div class="product-view-info">
      <?php woocommerce_show_product_images()?>
    </div>
    <?php
  }


  /**
   * Product teaser
   * @see woocommerce/templates/content-single-product.php
   */
  function sassy_widget_content_element_elements_product_teaser_info() {
    if (!is_product()) {
      return;
    }
    ?>
    <meta itemprop="url" content="<?php the_permalink()?>" />
    <div class="product-view-info">
      <div class="summary entry-summary">
      <?php
        do_action('woocommerce_single_product_summary');
      ?>
      </div>
    </div>
    <?php
  }


  /**
   * Product teaser
   * @see woocommerce/templates/content-single-product.php
   */
  function sassy_widget_content_element_elements_product_teaser() {
    if (!is_product()) {
      return;
    }
    if (SassySettings::get('woocommerce_product_show_title') == 'beforeimage') {
      woocommerce_template_single_title();
    }
    ?>
    <meta itemprop="url" content="<?php the_permalink()?>" />
    <div class="product-view-info product-view-info-full-block">
      <?php
        woocommerce_show_product_images();
      ?>
      <div class="summary entry-summary">
      <?php
        do_action('woocommerce_single_product_summary');
      ?>
      </div>
    </div>
    <?php
  }


  /**
   * Product information
   * @see woocommerce/templates/content-single-product.php
   */
  function sassy_widget_content_element_elements_product_info() {
    if (!is_product()) {
      return;
    }
    woocommerce_output_product_data_tabs();
  }


  /**
   * Product related products
   * @see woocommerce/templates/content-single-product.php
   */
  function sassy_widget_content_element_elements_product_related() {
    if (!is_product()) {
      return;
    }
    woocommerce_upsell_display();
    woocommerce_output_related_products();
  }


  /**
   * Product tabs
   */
  function sassy_widget_content_element_elements_product_tab($args) {
    if (!is_product()) {
      return;
    }
    static $tabs = array();

    if (!$tabs) {
      $tabs = apply_filters('woocommerce_product_tabs', array());
    }

    if (empty($tabs[$args['tab']])) {
      return;
    }
    call_user_func($tabs[$args['tab']]['callback']);
    return $args;
  }


  /**
   * Adding woocommerce stuff to sassy compute rule tag
   */
  function sassy_compute_rule_tag($state, $name, $args) {
    if ($name == 'is_woocommerce') {
      $state = is_woocommerce();
    }
    return $state;
  }

  /**
   * Add rules to skip some of post type variants for selection rule
   */
  function sassy_layout_selection_rule_skip_types($types) {

    // This come from most commerces not only WooCommerce
    $types['product'] = array('archive_entry');

    return $types;
  }

}

return new SassyWoocommerce();
