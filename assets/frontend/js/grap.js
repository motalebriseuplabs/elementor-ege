/**
 * Circular Diagram Widget JavaScript - Interactive Functionality
 *
 * @package Elementoredge
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Circular Diagram Widget Handler
     */
    var CircularDiagramHandler = function($scope, $) {
        var $widget = $scope.find('.edge-grap-widget');
        var $diagram = $widget.find('.edge-circular-diagram');
        var $badges = $widget.find('.user-badge');
        var $centerLogo = $widget.find('.center-logo');

        // Initialize the widget
        init();

        function init() {
            if ($widget.length === 0) return;

            setupInteractivity();
            setupAnimations();
            setupResponsiveHandling();
            setupAccessibility();
        }

        /**
         * Setup interactive behaviors
         */
        function setupInteractivity() {
            // Simplified hover: only elevate hovered badge
            $badges.on('mouseenter', function() {
                $(this).addClass('hover-elevate');
            }).on('mouseleave', function() {
                $(this).removeClass('hover-elevate');
            });

            // Click interactions
            $badges.on('click', function(e) {
                e.preventDefault();
                var $badge = $(this);
                var badgeText = $badge.find('.badge-text').text();

                // Trigger custom event
                $widget.trigger('badgeClicked', [badgeText, $badge]);

                // Add click animation
                $badge.addClass('clicked');
                setTimeout(function() {
                    $badge.removeClass('clicked');
                }, 300);
            });

            // Center logo click
            $centerLogo.on('click', function(e) {
                e.preventDefault();
                $(this).addClass('center-clicked');

                // Trigger custom event
                $widget.trigger('centerLogoClicked');

                setTimeout(function() {
                    $centerLogo.removeClass('center-clicked');
                }, 500);
            });
        }

        /**
         * Create connection pulse effect
         */
        function createConnectionPulse($badge) {
            var badgeRect = $badge[0].getBoundingClientRect();
            var centerRect = $centerLogo[0].getBoundingClientRect();
            var diagramRect = $diagram[0].getBoundingClientRect();

            var $pulse = $('<div class="pulse-effect"></div>');

            // Calculate line position
            var startX = (centerRect.left + centerRect.width / 2) - diagramRect.left;
            var startY = (centerRect.top + centerRect.height / 2) - diagramRect.top;
            var endX = (badgeRect.left + badgeRect.width / 2) - diagramRect.left;
            var endY = (badgeRect.top + badgeRect.height / 2) - diagramRect.top;

            var length = Math.sqrt(Math.pow(endX - startX, 2) + Math.pow(endY - startY, 2));
            var angle = Math.atan2(endY - startY, endX - startX) * 180 / Math.PI;

            $pulse.css({
                position: 'absolute',
                left: startX + 'px',
                top: startY + 'px',
                width: length + 'px',
                height: '2px',
                background: 'linear-gradient(90deg, #8b5cf6, #06b6d4)',
                transformOrigin: '0 50%',
                transform: 'rotate(' + angle + 'deg)',
                opacity: '0',
                zIndex: '3'
            });

            $diagram.append($pulse);

            // Animate pulse
            $pulse.animate({ opacity: 1 }, 200).animate({ opacity: 0 }, 800);
        }

        /**
         * Setup entrance animations
         */
        function setupAnimations() {
            // Check if widget is in viewport
            function isInViewport($element) {
                var elementTop = $element.offset().top;
                var elementBottom = elementTop + $element.outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();

                return elementBottom > viewportTop && elementTop < viewportBottom;
            }

            // Trigger animations when widget comes into view
            function checkAndAnimate() {
                if (isInViewport($widget) && !$widget.hasClass('animated')) {
                    $widget.addClass('animated');
                    animateEntrance();
                }
            }

            // Initial check
            checkAndAnimate();

            // Check on scroll
            $(window).on('scroll', checkAndAnimate);
        }

        /**
         * Animate widget entrance
         */
        function animateEntrance() {
            // Center logo subtle fade-in
            $centerLogo.css({ opacity: 0 }).animate({ opacity: 1 }, 600);

            // Badges animation
            $badges.each(function(index) {
                var $badge = $(this);
                setTimeout(function() {
                    $badge.addClass('animate-in');
                }, index * 100);
            });
        }

        /**
         * Setup responsive handling
         */
        function setupResponsiveHandling() {
            var resizeTimer;

            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    recalculatePositions();
                }, 250);
            });
        }

        /**
         * Recalculate badge positions for responsive design
         */
        function recalculatePositions() {
            // Positions are computed server-side in PHP; keep function for future dynamic controls.
            return true;
        }

        /**
         * Setup accessibility features
         */
        function setupAccessibility() {
            // Add ARIA labels
            $badges.attr('role', 'button');
            $badges.attr('tabindex', '0');

            $badges.each(function() {
                var $badge = $(this);
                var text = $badge.find('.badge-text').text();
                $badge.attr('aria-label', 'User type: ' + text);
            });

            // Keyboard navigation
            $badges.on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }

                // Arrow key navigation
                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    var $next = $(this).next('.user-badge');
                    if ($next.length === 0) {
                        $next = $badges.first();
                    }
                    $next.focus();
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    var $prev = $(this).prev('.user-badge');
                    if ($prev.length === 0) {
                        $prev = $badges.last();
                    }
                    $prev.focus();
                }
            });

            // Center logo accessibility
            $centerLogo.attr('role', 'button');
            $centerLogo.attr('tabindex', '0');
            $centerLogo.attr('aria-label', 'Center logo');

            $centerLogo.on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });
        }

        /**
         * Public API
         */
        return {
            getBadges: function() {
                return $badges;
            },
            getCenterLogo: function() {
                return $centerLogo;
            },
            animateEntrance: animateEntrance,
            recalculatePositions: recalculatePositions
        };
    };

    // Register the handler with Elementor
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/elementor-edge-grap.default', CircularDiagramHandler);
    });

    // Also initialize for non-Elementor contexts
    $(document).ready(function() {
        if (typeof elementorFrontend === 'undefined') {
            $('.elementor-widget-elementor-edge-grap').each(function() {
                CircularDiagramHandler($(this), $);
            });
        }
    });

})(jQuery);

/**
 * Additional CSS for animations (injected via JavaScript)
 */
(function() {
    'use strict';

    var additionalStyles = `
        <style id="edge-grap-dynamic-styles">
            .edge-grap-widget .user-badge.hover-elevate { box-shadow: 0 6px 20px rgba(0,0,0,0.12); }
            .edge-grap-widget .user-badge.animate-in { opacity:1; }

            .edge-grap-widget .user-badge:focus {
                outline: 3px solid #3b82f6;
                outline-offset: 3px;
                z-index: 10;
            }

            .edge-grap-widget .center-logo:focus {
                outline: 3px solid #3b82f6;
                outline-offset: 3px;
            }
        </style>
    `;

    // Inject styles when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.getElementById('edge-grap-dynamic-styles')) {
                document.head.insertAdjacentHTML('beforeend', additionalStyles);
            }
        });
    } else {
        if (!document.getElementById('edge-grap-dynamic-styles')) {
            document.head.insertAdjacentHTML('beforeend', additionalStyles);
        }
    }
})();
