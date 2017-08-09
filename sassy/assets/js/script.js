/**
 * Main theme settings object
 */
if (typeof sassy === 'undefined') {
  var sassy = {};
}


/**
 * Theme easing effect
 */
jQuery.easing.easeOutCubic=function(x,t,b,c,d){if((t/=d/2)<1)return-c/2*(Math.sqrt(1-t*t)-1)+b;return c/2*(Math.sqrt(1-(t-=2)*t)+1)+b;};


/**
 * Query string parameters.
 *
 * @param string
 *
 * @return array
 */
function queryString(urlparameters) {
  var query_string = {};
  var query = urlparameters;
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = pair[1];
    }
    else if (typeof query_string[pair[0]] === "string") {
      var arr = [ query_string[pair[0]], pair[1] ];
      query_string[pair[0]] = arr;
    }
    else {
      query_string[pair[0]].push(pair[1]);
    }
  }
  return query_string;
}


/**
 * theme
 */
(function($) {


  /**
   * Sassy modal window implementation
   *
   * @param options
   *
   * @returns {jQuery}
   */
  $.modalWindow = function(options) {
    var settings = $.extend({
      href: null,
      content: null
    }, options);
    var overlay = $('#sassyModalWindowOverlay');
    var container = $('#sassyModalWindowContainer');
    $(container).empty();
    if (options == 'close') {
      $('.the-wrapper').removeClass('modalwindow-is-active');
      $(overlay).fadeOut(150);
      if (window.location.hash == '#sassyModalWindowContainer') {
        window.location.hash = '';
      }
      return this;
    }
    else if (options == 'destroy') {
      $('.the-wrapper').removeClass('modalwindow-is-active');
      $(overlay).remove();
      if (window.location.hash == '#sassyModalWindowContainer') {
        window.location.hash = '';
      }
      return this;
    }
    if ($(overlay).length < 1) {
      overlay = $('<div />', { id: 'sassyModalWindowOverlay' })
        .appendTo('body')
        .on('click', function() {
          $.modalWindow('close');
        })
        .hide();
      container = $('<div />', { id: 'sassyModalWindowContainer' })
        .appendTo(overlay);
    }
    if (settings.href && typeof(settings.href) == 'string' && (settings.href.indexOf('http://') == 0 || settings.href.indexOf('/') == 0)) {
      $(container).load(settings.href);
    }
    else if (settings.href) {
      $(settings.href)
        .clone()
        .appendTo(container);
    }
    else if (settings.content) {
      $(settings.content)
        .appendTo(container);
    }
    $(container)
      .on('click', function(event) {
        event.stopPropagation();
    });

    window.location.hash = 'sassyModalWindowContainer';

    $(overlay).fadeIn(150, function() {
      $(window).one('hashchange', function() {
        $.modalWindow('close');
      });
    });

    $('.the-wrapper')
      .addClass('modalwindow-is-active');

    return this;
  }


  /**
   * Allow check with .is(':offscreen');
   *
   * @param el
   *
   * @returns {boolean}
   */
  $.expr.filters.offscreen = function(el) {
    return (
      (el.offsetLeft + el.offsetWidth) < 0
      || (el.offsetTop + el.offsetHeight) < 0
      || (el.offsetLeft > window.innerWidth || el.offsetTop > window.innerHeight)
      );
  };


  /**
   * Menu position corrector
   *
   * @param options
   *
   * @returns {$.fn}
   */
  $.fn.positionCorrection = function(options) {

    var settings = $.extend({
      element: null,
      event: 'mouseenter'
    }, options);

    if (!options.element) {
      return this;
    }

    this.on(settings.event, function() {

      var el = $(this).find(settings.element);
      if (el.length < 1) {
        return;
      }
      $(el)
        .css('min-width', $(this).width())
        .show();
      if (settings.rightToElement) {
        if ($(this).outerWidth()+$(el).outerWidth()+5 >= $(this).offsetParent().outerWidth()) {
          $(el).css('max-width', $(this).offsetParent().outerWidth()-$(this).outerWidth()-5 );
        }
        if ($(this).position().left+$(this).outerWidth()+$(el).outerWidth() >= $(this).offsetParent().outerWidth()) {
          $(el).css({ right: $(this).outerWidth(), top: $(this).position().top });
        }
        else {
          $(el).css({ left: $(this).outerWidth(), top: $(this).position().top });
        }
      }
      else {
        var offsetParent = $(this).offsetParent().outerWidth();
        var oldX = $(el).position().left;
        $(el).css('left', 0);
        var realWidth = $(el).width();
        if (oldX + realWidth > offsetParent + 5) {
          $(el).css({ left: 'auto', right: 0 });
        }
        else {
          $(el).css({ left: '' });
        }
      }
    });
    return this;
  };



  /**
   * Collapsible Widgets
   */
  $.fn.collapsibleWidgets = function(options) {

    var settings = $.extend({
      collapsed: false
    }, options);

    var el = this;
    var titleEl = $(this).find('.widget-title').first();
    if ($(titleEl).length < 1) {
      return this;
    }

    if ($(el).hasClass('widget-collapsible-processed') && options !== 'destroy') {
      return this;
    }

    if (options == 'destroy') {
      $(titleEl).off('click', el.showHideCallback);
      $(el)
        .removeClass('widget-collapsible-processed')
        .height('auto');
      return this;
    }

    var origOverflow = $(this).css('overflow');

    el.showHideCallback = function() {
      if ($(el).hasClass('widget-collapsed')) {
        $(el)
          .height('auto')
          .css('overflow', origOverflow)
          .removeClass('widget-collapsed');
      }
      else {
        $(el)
          .height($(titleEl).outerHeight())
          .css('overflow', 'hidden')
          .addClass('widget-collapsed');
      }
    };

    $(this)
      .addClass('widget-collapsible-processed')

    if (!settings.collapsed) {
      $(this)
        .removeClass('widget-collapsed');
    }

    $(titleEl)
      .on('click', el.showHideCallback)
      .trigger('click');
    return this;
  }



  /**
   * Attach Sticky scroll
   */
  $(document).ready(function() {


    /**
     * Enable smooth scrolling
     */
    if (sassy.settings.decoration_smooth_scrolling) {
      $.srSmoothscroll({
        speed: sassy.settings.decoration_smooth_scrolling/1.5
      });
    }


    /**
     * Scroll to Top decoration button
     */
    if (sassy.settings.decoration_scroll_to_top) {
      $(window).scroll(function() {
        if ($(this).scrollTop() > 250) {
          $('.back-to-top').fadeIn(250);
        }
        else {
          $('.back-to-top').fadeOut(250);
        }
      });
      $('<span />', { class: 'back-to-top fa fa-arrow-circle-o-up' })
        .appendTo('body')
        .on('click', function(event) {
          event.preventDefault();
          $('html, body').animate({ scrollTop: 0 }, 250);
          return false;
        });
    }


    /**
     * Enable sticky srcroll.
     */
    $('.sticky-scroll').each(function() {
      var self = this;
      var top = $(this).offset().top;
      var height = $(this).height();
      var position = $(this).css('position');
      var display = $(this).css('display');
      if ($(this).hasClass('sticky-scroll-top-hidden') || $(this).hasClass('sticky-scroll-bottom-hidden')) {
        $(this).hide()
      }
      $(window)
        .scroll(function(event) {

          var y = $(this).scrollTop();

          // Top
          if ($(self).hasClass('sticky-scroll-top') || $(self).hasClass('sticky-scroll-top-hidden')) {
            if (y > top + height) {
              $(self).addClass('sticky-scroll-process')
              if ($(self).hasClass('sticky-scroll-top-hidden')) {
                $(self).slideDown(75, 'easeOutCubic');
              }
            }
            else {
              $(self).removeClass('sticky-scroll-process')
              if ($(self).hasClass('sticky-scroll-top-hidden')) {
                $(self).slideUp(75, 'easeOutCubic');
              }
            }
          }

          // Bottom
          if ($(self).hasClass('sticky-scroll-bottom') || $(self).hasClass('sticky-scroll-bottom-hidden')) {
            if (y < top - height) {
              $(self).addClass('sticky-scroll-process')
              if ($(self).hasClass('sticky-scroll-bottom-hidden')) {
                $(self).slideDown(75, 'easeOutCubic');
              }
            }
            else {
              $(self).removeClass('sticky-scroll-process')
              if ($(self).hasClass('sticky-scroll-bottom-hidden')) {
                $(self).slideUp(75, 'easeOutCubic');
              }
            }
          }

        })
        .trigger('scroll');
    });


   
    /**
     * Media container fix
     */
    $('iframe[src*="youtube"]').each(function() {
      if ($(this).parent('.media-container').length < 1) {
        $(this).wrap('<div class="media-container" />');
      }
    });


    /**
     * Copy aria-required attributes also as required
     */
    $(':input[aria-required]').each(function() {
      $(this).attr('required', $(this).attr('aria-required'));
    });


    $('.sassy-masonry')
      .each(function() {
        var oneItem = $('.archive-entry', this).first();
        var parent = $(oneItem).closest('.widget_sassy_main_loop,.panel-grid-cell');
        $(parent).masonry({
          itemSelector: '.archive-entry'
        });
      })


    /**
     * Search Autocomplete
     */
    if (sassy.settings.components_enable_searches_autocomplete) {
      $('input.search-field').each(function () {
        var prevValString = '';
        var searchAutoCompleteCallback = function (listElement, string, fieldElement) {
          if (prevValString == string) {
            $(form)
              .addClass('autocomplete-done');
            $(listElement).slideDown(100);
          }
          prevValString = string;
          var form = $(listElement).closest('form');
          $(form)
            .addClass('autocomplete-loading')
            .removeClass('autocomplete-done');
          var data = {
            q: string,
            post_type: $(form).find(':input[name=post_type]').val(),
            limit: $(form).find(':input[name=post_type]').val()
          };
          $.ajax({
            type: 'GET',
            url: sassy.settings.base + '?sassy-ajax=search-autocomplete',
            data: data,
            cache: true,
            success: function (response) {
              $(listElement)
                .html(response)
                .slideDown(100, 'easeOutCubic', function () {
                  $(form)
                    .removeClass('autocomplete-loading')
                    .addClass('autocomplete-done');
                  $(document).one('click', function () {
                    $(listElement).slideUp(100, 'easeOutCubic', function () {
                      $(form).removeClass('autocomplete-done');
                    });
                  });
                });
            },
            error: function () {
              $(form)
                .removeClass('autocomplete-loading')
                .removeClass('autocomplete-done');
            }
          });
        };
        var autocompleteList = $('<div class="search-autocomplete-list" />').insertAfter(this).hide();
        var fieldElement = this;
        var searchAutocomplete_timeout = null;
        $(this)
          .on('keyup', function () {
            var string = $(this).val();
            if (string.length <= 2) {
              $(autocompleteList).slideUp(100, 'easeOutCubic');
              $(this).closest('form').removeClass('autocomplete-done');
              return;
            }
            clearTimeout(searchAutocomplete_timeout);
            searchAutocomplete_timeout = setTimeout(function () {
              searchAutoCompleteCallback(autocompleteList, string, fieldElement)
            }, 300);
          })
          .attr('autocomplete', 'off');
      });
    }


    /**
     * Collapsible Widgets
     */
    for (var i in sassy.settings.mqs) {
      if (window.matchMedia('(max-width: ' + sassy.settings.mqs[i] + 'px)').matches) {
        $('.mq-collapsible.mq-collapsible-' + sassy.settings.mqs[i]).collapsibleWidgets({collapsed: true});
        $('.mq-' + sassy.settings.mqs[i]).hide({collapsed: true});
      }
    }


    /**
     * Mobile behavior class
     */
    var mobileBehaviorResizeTimer = null;
    var mobileBehaviorResizeTimer_callback = function() {
      if (sassy.settings.mobile_behavior_breakpoint && top.matchMedia('(max-width: ' + sassy.settings.mobile_behavior_breakpoint + 'px)').matches) {
        $('body').addClass('mobile-behavior');
      }
      else {
        $('body').removeClass('mobile-behavior');
      }
    };
    $(window)
      .on('resize', function() {
        clearTimeout(mobileBehaviorResizeTimer_callback);
        mobileBehaviorResizeTimer = setTimeout(mobileBehaviorResizeTimer_callback, 100);
      })
      .trigger('resize');


    /**
     * Hamburger menu init
     */
    $('.responsive-hamburger-menu').each(function() {
      var trigger = $('.responsive-hamburger-menu-trigger', this);
      if (trigger.length < 1) {
        trigger = $('<a />', { class: 'responsive-hamburger-menu-trigger', href: '#' });
        $(trigger).prependTo(this);
      }
      var label = $('.current_page_item,.current_menu_item', this).first().children('a').text().trim();
      if (!label) {
        label = sassy.settings.labels.menu;
      }
      var menu = $('.menu', this);
      $(trigger)
        .text(label)
        .on('click', function(event) {
          event.preventDefault();
          $(menu).toggleClass('responsive-hamburger-menu-expand', 150);
        });
    });


    /**
     * Menu position fixes and responsive enhancements.
     * Do these things only when breakpoint is set and device is touchable.
     * TODO do this when resize, need to preserve dropdown menu reformat
     */
    if (sassy.settings.mobile_behavior_breakpoint && Modernizr.touch && top.matchMedia('(max-width: ' + sassy.settings.mobile_behavior_breakpoint + 'px)').matches) {

      $('.responsive-none-menu .menu > .menu-item')
        .has('> .sub-menu')
        .find('> a').on('click', function(event) {
          $(this).one('blur', function() {
            if (this.hasOwnProperty('sassyActive')) {
              delete this.sassyActive;
            }
          });
          if (!this.hasOwnProperty('sassyActive')) {
            this.sassyActive = true;
            event.preventDefault();
          }
        });


        /**
         * Popup menu responsives
         */
        $('.responsive-popup-menu .menu > .menu-item,.responsive-popup-menu.menu > .menu-item')
          .has('> .sub-menu')
          .on('click', function(event) {
            var newEl = $(this).clone(false);
            $('.sub-menu', newEl).show();
            $.modalWindow({
              content: newEl
            });
            $(newEl)
              .wrap('<ul></ul>');
            event.preventDefault();
          })
          .find('> .sub-menu').hide();


        /**
         * Dropdown menu responsives
         */
        $('.responsive-dropdown-menu .menu')
          .not('.responsive-dropdown-menu-processed')
          .addClass('responsive-dropdown-menu-processed')
          .each(function() {
            var select = $('<select />')
              .insertBefore($(this).hide())
              .on('change', function(event) {
                window.location.href = $(this).val();
              })
              .addClass('dropdown-menu');
            $('> li a', this).each(function() {
              var href = $(this).attr('href');
              if (!href) {
                return;
              }
              var parentLi = $(this).parent('li');
              var indent = Array($(this).parentsUntil('.menu').length).join('-') + ' ';
              var option = $('<option />')
                .text(indent + $(this).text())
                .attr('value', $(this).attr('href'))
                .appendTo(select);
              if ($(parentLi).hasClass('current_menu_item') || $(parentLi).hasClass('current_page_item')) {
                $(option).attr('selected', 'selected');
              }

            });
          });

    }
    /**
     * Default enhancement
     */
    else {
      $('.horizontal-menu .menu > .menu-item')
        .positionCorrection({ element: '> .sub-menu' });
      $('.vertical-menu .menu > .menu-item')
        .positionCorrection({ element: '> .sub-menu', rightToElement: true });

      /**
       * Accordion menues
       */
      $('.vertical-menu-accordion .menu > .menu-item-has-children > a')
        .on('click', function(event) {
          event.preventDefault();
          $(this).closest('.menu').find('.active-trail').removeClass('active-trail');
          var c = $(this).closest('li').find('ul').first();
          $(this).closest('.menu').find('.sub-menu').slideUp(100, 'easeOutCubic');
          if (!$(c).is(':visible')) {
            $(c).slideDown(100, 'easeOutCubic');
            $(this).closest('li').addClass('active-trail');
          }
        });
      $('.current_page_ancestor > a').trigger('click');
    }


    /**
     * Frontend editing supports goes here
     *
     * Images that are on links should avoid link default behavior
     */
    $('body.logged-in.admin-bar.customize-support .entry-singular a img').each(function() {
      $(this).closest('a').on('click', function(event) {
        if ($('body').hasClass('fee-on')) {
          event.preventDefault();
        }
      });
    });

  });

}(jQuery));


/**
 * Makes "skip to content" link work correctly in IE9, Chrome, and Opera
 * for better accessibility.
 *
 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
 */
(function() {
  var ua = navigator.userAgent.toLowerCase();
  if ( ( ua.indexOf( 'webkit' ) > -1 || ua.indexOf( 'opera' ) > -1 || ua.indexOf( 'msie' ) > -1 ) &&
    document.getElementById && window.addEventListener ) {
    window.addEventListener( 'hashchange', function() {
      var element = document.getElementById( location.hash.substring( 1 ) );
      if ( element ) {
        if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.nodeName ) ) {
          element.tabIndex = -1;
        }
        element.focus();
      }
    }, false );
  }
})();
