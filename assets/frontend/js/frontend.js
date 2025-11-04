/**
 * Elementor edge Frontend Scripts
 *
 * @package Elementoredge
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Elementor edge Frontend Class
     */
    class ElementoredgeFrontend {
        constructor() {
            this.init();
        }

        /**
         * Initialize
         */
        init() {
            this.bindEvents();
            this.loadTranslations();
        }

        /**
         * Load translations
         */
        loadTranslations() {
            // Get localized strings from WordPress
            this.strings = (typeof elementoredge !== 'undefined' && elementoredge.strings) ? elementoredge.strings : {
                loading: 'Loading...',
                error: 'Error',
                success: 'Success',
                confirm: 'Are you sure?',
                cancel: 'Cancel',
                save: 'Save',
                close: 'Close',
                next: 'Next',
                previous: 'Previous',
                search: 'Search',
                no_results: 'No results found',
                select_option: 'Select an option'
            };
        }

        /**
         * Bind Events
         */
        bindEvents() {
            $(window).on('elementor/frontend/init', this.onElementorFrontendInit.bind(this));
        }

        /**
         * On Elementor Frontend Init
         */
        onElementorFrontendInit() {
            // Add custom handlers for Elementor widgets
            elementorFrontend.hooks.addAction('frontend/element_ready/widget', this.onWidgetReady.bind(this));
        }

        /**
         * On Widget Ready
         */
        onWidgetReady($scope) {
            const widgetType = $scope.data('widget_type');

            // Handle different widget types
            switch (widgetType) {
                case 'elementor-edge-example.default':
                    this.handledgexampleWidget($scope);
                    break;
                default:
                    break;
            }
        }

        /**
         * Handle Example Widget
         */
        handledgexampleWidget($scope) {
            // Add your widget-specific functionality here
            const $widget = $scope.find('.elementor-edge-example');

            if ($widget.length) {
                this.initExampleWidget($widget);
            }
        }

        /**
         * Initialize Example Widget
         */
        initExampleWidget($widget) {
            // Example functionality with translations
            $widget.on('click', '.elementor-edge-button', (e) => {
                e.preventDefault();

                if (confirm(this.strings.confirm)) {
                    this.showMessage(this.strings.success, 'success');
                }
            });
        }

        /**
         * Show Message
         */
        showMessage(message, type = 'info') {
            // Create message element
            const $message = $('<div class="elementor-edge-message elementor-edge-message--' + type + '">')
                .text(message)
                .appendTo('body');

            // Show message
            $message.fadeIn();

            // Hide after 3 seconds
            setTimeout(() => {
                $message.fadeOut(() => {
                    $message.remove();
                });
            }, 3000);
        }

        /**
         * Get Translation
         */
        getTranslation(key, fallback = '') {
            return this.strings[key] || fallback;
        }
    }

    // Initialize when DOM is ready
    $(document).ready(() => {
        new ElementoredgeFrontend();
    });

})(jQuery);
