/**
 * WooCommerce related
 */
(function($) {

  $(document).ready(function() {

    /**
     * Menu position fixes also sub-menus
     * TODO do this when resize, need to preserve dropdown menu reformat
     */
    if (sassy.settings.mobile_behavior_breakpoint && Modernizr.touch && window.matchMedia('(max-width: ' + sassy.settings.mobile_behavior_breakpoint + 'px)').matches) {

      $(document).on('click', '.widget_woocommerce_widget_cart .cart-contents', function(event) {
          event.preventDefault();
          $.modalWindow({
            href: $('.widget_shopping_cart_content')
          });
        });

      $(document).on('click', '.widget_sassy_woocommerce_wishlist .count-wrapper', function(event) {
        event.preventDefault();
        $.modalWindow({
          href: $('.wishlist_cart_content')
        });
      });

    }
    else {
      $('.widget_woocommerce_widget_cart')
        .positionCorrection({ element: '.widget_shopping_cart_content' });
      $('.widget_sassy_woocommerce_wishlist')
        .positionCorrection({ element: '.wishlist_cart_content' });
    }


    /**
     * Cart fragment (cart items count)
     */
    $('.widget_shopping_cart_content')
      .before('<a class="cart-contents"><span class="count">0</span></a>');

    /**
     * Animate adding to cart.
     */
    $('.add_to_cart_button')
      .on('click', function(event) {

        if ($('.widget_shopping_cart_content').length > 0) {
          var cartEl = $('.widget_shopping_cart_content').first();
        }
        else {
          return;
        }

        var pos = null;
        if ($(cartEl).is(':hidden')) {
          $(cartEl).show(0, function() {
            pos = $(cartEl).offset();
            $(this).hide();
          });
        }
        else {
          pos = $(cartEl).offset();
        }

        if (!pos) {
          return;
        }

        var productEl = $(this).closest('.product');
        var productParentEl = $(productEl).parent();

        $(productEl)
          .clone()
          .appendTo('body')
          .addClass('cloned-product')
          .wrap('<ul class="cloned-product-wrapper" />')
          .css({
            position: 'absolute',
            zIndex: 99999,
            top: $(productEl).offset().top,
            left: $(productEl).offset().left
          })
          .animate({
            top: pos.top,
            left: pos.left,
            width: '48px'
            }, 250, 'easeOutCubic', function() {
              $(this).remove();
          });

      });


    /**
     * Fix variation price settings.
     */
    $('.variations_form').on('wc_variation_form', function() {

      var priceElement = $(this).closest('.product.entry').find('.summary p.price');
      $(this)
        .attr('data-default-price-val', $(priceElement).html())
        .on('found_variation', function (event, variation) {
          if (variation.price_html) {
            $(priceElement).html(variation.price_html);
          }
        })
        .on('reset_image', function(event, variations) {
          if ($(this).attr('data-default-price-val') != $(priceElement).html()) {
            $(priceElement).html($(this).attr('data-default-price-val'));
          }
        })
        .find('.single_variation').hide();

      $(this).find('.single_variation_wrap')
        .on('show_variation', function() {
          $(this).slideDown(75);
        });

    });


    /**
     * Wishlist
     */
    var wooCommerceWishList = function(id) {
      this.id = id;
      this.status = function() {
        var data = localStorage.getItem('sassyWooCommerceWishList');
        if (data) {
          data = $.parseJSON(data);
          if (data && data.hasOwnProperty(this.id)) {
            return true;
          }
        }
        return false;
      };
      this.list = function() {
        var data = localStorage.getItem('sassyWooCommerceWishList');
        if (data) {
          return $.parseJSON(data);
        }
        else {
          return {};
        }
      };
      this.add = function(html) {
        var data = localStorage.getItem('sassyWooCommerceWishList');
        if (data) {
          data = $.parseJSON(data);
          if (!data) {
            data = {};
          }
          data[this.id] = (html ? html : '');
        }
        localStorage.setItem('sassyWooCommerceWishList', JSON.stringify(data));
        return true;
      };
      this.remove = function() {
        var data = localStorage.getItem('sassyWooCommerceWishList');
        if (data) {
          data = $.parseJSON(data);
          if (data) {
            delete data[this.id];
          }
        }
        localStorage.setItem('sassyWooCommerceWishList', JSON.stringify(data));
        return true;
      };
      this.update = function() {
      };
      return this;
    };


    $('.widget_sassy_woocommerce_wishlist')
      .on('wishlist-update', function() {

        var countElement = $('.count', this);
        if (countElement.length < 1) {
          countElement = $('<span class="count" />').appendTo(this).wrap('<span class="count-wrapper" />');
        }

        var elementList = $('.product_list_widget', this);
        if (elementList.length) {
          $(elementList).empty();
        }
        else {
          elementList = $('<ul class="product_list_widget" />').appendTo(this);
          $(elementList).wrap('<div class="wishlist_cart_content" />');
        }
        var list = (new wooCommerceWishList(0)).list();
        var c = 0;
        for (var i in list) {
          c++;
          var el = $('<li />');
          $(el).appendTo(elementList);
          $(el).html(list[i]);
        }
        if (c) {
          $(elementList).show();
        }
        else {
          $(elementList).hide();
        }
        $(countElement).text(c);
      })
      .on('click', 'a.remove', function(event) {
        event.preventDefault();
        var o = (new wooCommerceWishList($(this).attr('data-post-id')));
        o.remove();
        $(this).closest('li').remove();
        o.update();
        $('.product-wishlist-actions,.widget_sassy_woocommerce_wishlist').trigger('wishlist-update');
      })
      .trigger('wishlist-update');


    /**
     * Hook to product teaser actions.
     */
    $('.product-wishlist-actions')
      .on('wishlist-update', function() {
        $(this).empty();
        var self = this;
        var o = (new wooCommerceWishList($(this).attr('data-post-id')));
        var postId = $(this).attr('data-post-id');
        var a = $('<a />', { href: '#' })
          .text(o.status() ? $(this).attr('data-label-remove') : $(this).attr('data-label-add'))
          .addClass('sassy-wishlist-status-' + (o.status() ? '1' : '0'))
          .on('click', function(event) {
            event.preventDefault();
            if (o.status()) {
              o.remove();
            }
            else {
              var productWrapper = $(self).closest('.entry');
              var element = $('<p />');
              var remove = $('<a />', { href: '#', class: 'remove', 'data-post-id': postId })
                .prependTo(element)
                .text('×')
              var a = $('<a />', { href: sassy.settings.base + '?p=' + postId })
                .text($('.product_title.entry-title', productWrapper).first().text())
                .appendTo(element);
              $('.images .wp-post-image', productWrapper)
                .first()
                .clone(false)
                .appendTo(a);
              o.add($(element).html());
            }
            $(self).trigger('wishlist-update');
            $('.widget_sassy_woocommerce_wishlist').trigger('wishlist-update');
          })
          .appendTo(this);

      })
      .trigger('wishlist-update');


  });
}(jQuery));
