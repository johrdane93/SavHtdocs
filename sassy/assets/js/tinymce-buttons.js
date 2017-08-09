/**
 * Tinymce buttons
 */
(function() {
  tinymce.PluginManager.add('sassy', function (editor, url) {

    function showDialog() {
      var win;
      var charMapPanel = {
        type: 'container',
        html: '<div id="sassy-mce-fontawesome-charmap"></div>',
        onclick: function (e) {
          var target = e.target;
          if (target.nodeName == 'A') {
            var iconMarkup = '<i class="fa fa-' + target.getAttribute('data-name') + '"></i>';
            editor.execCommand('mceInsertContent', false, iconMarkup);
            if (!e.ctrlKey) {
              win.close();
            }
          }
        },
        onmouseover: function (e) {
          var target = e.target;
          if (target.nodeName == 'A') {
            win.find('#preview').text(target.innerText);
            win.find('#previewTitle').text(target.getAttribute('data-name'));
          }
          else {
            win.find('#preview').text(' ');
            win.find('#previewTitle').text(' ');
          }
        }
      };

      jQuery.getJSON(sassy.themeUrl + '/assets/content/fontawesome-vars.json', function(charmap) {
        var gridHTML = '<div class="mce-charmap sassy-fontawesome-charmap">';
        for (var i = 0; i < charmap.length; i++) {
          var char = String.fromCharCode(charmap[i][1].replace("\f", "0xf"));
          gridHTML += '<a href="#" class="charmap-char fa" data-name="' + charmap[i][0] + '">' + char + '</a>';
        }
        gridHTML += '</div>';
        jQuery('#sassy-mce-fontawesome-charmap').html(gridHTML);
      });

      win = editor.windowManager.open({
        title: "Special character",
        spacing: 10,
        padding: 10,
        items: [
          charMapPanel,
          {
            type: 'container',
            layout: 'flex',
            direction: 'column',
            align: 'center',
            spacing: 5,
            minWidth: 160,
            minHeight: 160,
            items: [
              {
                type: 'label',
                name: 'preview',
                text: ' ',
                style: 'font-family: FontAwesome; font-size: 40px; text-align: center',
                border: 1,
                minWidth: 140,
                minHeight: 80
              },
              {
                type: 'label',
                name: 'previewTitle',
                text: ' ',
                style: 'text-align: center',
                border: 1,
                minWidth: 140,
                minHeight: 80
              }
            ]
          }
        ],
        buttons: [
          {
            text: "Close", onclick: function () {
            win.close();
          }
          }
        ]
      });
    }

    editor.addButton('sassy_fontawesome_button', {
      icon: 'icon dashicons-carrot',
      tooltip: 'Special character',
      onclick: showDialog
    });

  });
}());
