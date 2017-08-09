<?php

/**
 * @file
 * WooCommerce helpers
 */



/**
 * Calculate the lowest available shipping method
 * available parameter values:
 *   non_free - show only rates bigger than 0
 *   default - get lower only from default selected shipping method
 *
 * @return rate|NULL
 */
function sassy_woocommerce_lowest_shipping_price() {
  $min_rate = NULL;
  $product = wc_get_product(get_the_ID());
  $shipping = new WC_Shipping;
  $methods = $shipping->load_shipping_methods();

  foreach ($methods as $method) {
    if ($method->enabled == 'yes') {
      $method->calculate_shipping(array(
        'contents_cost' => $product->price,
        'contents' => array(),
      ));
      foreach ($method->rates as $rate) {
        if ($min_rate === NULL || $min_rate->cost < $rate->cost) {
          $min_rate = $rate;
        }
      }
    }
  }
  if ($min_rate) {
    return $min_rate->cost;
  }
  return NULL;
}


/**
 * Output cart fragment.
 */
function sassy_woocommerce_cart_link_fragment() {
  $count = WC()->cart->get_cart_contents_count();
  ?>
  <a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woocommerce'); ?>">
    <span class="count">
      <?php
        if (SassySettings::get('components_comment_avatar_size') < 32) {
          printf(_n('%d item', '%d items', $count, 'woocommerce'), $count);
        }
        else {
          echo $count;
        }
      ?>
    </span>
  </a>
  <?php
}


/**
 * Class SASSY_Widget_Pagination
 */
class SASSY_Widget_WooCommerce_Wishlist extends WP_Widget {

  function __construct() {
    parent::__construct(FALSE, __('(sassy) WooCommerce wishlist', 'sassy'));
  }

  function widget($args, $instance) {
    echo $args['before_widget'];
    echo $args['after_widget'];
  }
}
