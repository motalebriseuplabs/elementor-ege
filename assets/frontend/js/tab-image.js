/**
 * Tab Image Widget JavaScript
 */

(function ($) {
  'use strict';

  /**
   * Tab Image Widget Handler
   */
  var TabImageWidget = function ($scope, $) {
    var $tabItems = $scope.find('.edge-tab-item');
    var $tabContents = $scope.find('.edge-tab-content');

    // Tab click handler
    $tabItems.on('click', function () {
      var $this = $(this);
      var tabIndex = $this.data('tab');

      // Remove active class from all tabs
      $tabItems.removeClass('active');
      $tabContents.removeClass('active');

      // Add active class to clicked tab
      $this.addClass('active');
      $scope.find('.edge-tab-content[data-content="' + tabIndex + '"]').addClass('active');
    });
  };

  // Initialize widget on Elementor frontend
  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction(
      'frontend/element_ready/edge-tab-image.default',
      TabImageWidget
    );
  });
})(jQuery);
