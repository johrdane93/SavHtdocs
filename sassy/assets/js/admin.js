(function($) {
  $(document).ready(function() {

    // Remove Logo and Background links from appearance menu.
    $('a[href$="header_image"],a[href$="background_image"]', '#menu-appearance').parent('li').remove();

  });
}(jQuery));
