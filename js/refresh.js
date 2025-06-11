(function ($, Drupal) {
  Drupal.behaviors.hetznerRefresh = {
    attach: function (context, settings) {
      setInterval(function () {
        $('#hetzner-server-table').load('/hetzner/servers #hetzner-server-table > *');
      }, 30000);
    }
  };
})(jQuery, Drupal);
