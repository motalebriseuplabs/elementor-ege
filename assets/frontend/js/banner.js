/**
 * Banner Widget JavaScript
 *
 * @package Elementoredge
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Video Poster Handler
     */
    function initVideoPosters() {
        $('.eldg-video-container').each(function() {
            const container = $(this);
            const poster = container.find('.eldg-video-poster');
            const iframe = container.find('iframe');
            const playBtn = container.find('.eldg-video-play-btn');

            // Handle play button click
            playBtn.on('click', function(e) {
                e.preventDefault();

                // Get video src from data attribute
                const videoSrc = iframe.attr('data-src');

                if (videoSrc) {
                    // Hide poster and show iframe
                    poster.fadeOut(300, function() {
                        iframe.attr('src', videoSrc).show();
                    });
                }
            });

            // Handle poster click (alternative trigger)
            poster.on('click', function(e) {
                if (!$(e.target).closest('.eldg-video-play-btn').length) {
                    playBtn.trigger('click');
                }
            });
        });
    }

    /**
     * Initialize when document is ready
     */
    $(document).ready(function() {
        initVideoPosters();
    });

    /**
     * Initialize for Elementor editor
     */
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/elementor-edge-banner.default', function($scope) {
            $scope.find('.eldg-video-container').each(function() {
                const container = $(this);
                const poster = container.find('.eldg-video-poster');
                const iframe = container.find('iframe');
                const playBtn = container.find('.eldg-video-play-btn');

                // Remove existing event handlers to prevent duplicates
                playBtn.off('click.bannerVideo');
                poster.off('click.bannerVideo');

                // Handle play button click
                playBtn.on('click.bannerVideo', function(e) {
                    e.preventDefault();

                    const videoSrc = iframe.attr('data-src');

                    if (videoSrc) {
                        poster.fadeOut(300, function() {
                            iframe.attr('src', videoSrc).show();
                        });
                    }
                });

                // Handle poster click
                poster.on('click.bannerVideo', function(e) {
                    if (!$(e.target).closest('.eldg-video-play-btn').length) {
                        playBtn.trigger('click');
                    }
                });
            });
        });
    });

})(jQuery);
