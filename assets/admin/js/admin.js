/**
 * Admin JavaScript for Elementor edge
 *
 * @package Elementoredge
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Admin Main Class
     */
    var ElementoredgeAdmin = {

        /**
         * Translations
         */
        strings: {},

        /**
         * Initialize admin functionality
         */
        init: function() {
            this.loadTranslations();
            this.bindEvents();
            this.initColorPickers();
            this.initWidgetGrid();
            this.handleSettingsForm();
        },

        /**
         * Load translations
         */
        loadTranslations: function() {
            // Get localized strings from WordPress
            this.strings = (typeof elementoredgeAdmin !== 'undefined' && elementoredgeAdmin.strings) ? elementoredgeAdmin.strings : {
                settings_saved: 'Settings saved successfully!',
                settings_error: 'Error saving settings. Please try again.',
                confirm_delete: 'Are you sure you want to delete this item?',
                confirm_reset: 'Are you sure you want to reset all settings?',
                widget_added: 'Widget added successfully!',
                widget_removed: 'Widget removed successfully!',
                invalid_input: 'Please enter valid information.',
                processing: 'Processing...',
                upload_file: 'Upload File',
                select_image: 'Select Image',
                remove_image: 'Remove Image'
            };
        },

        /**
         * Bind admin events
         */
        bindEvents: function() {
            $(document).ready(function() {
                ElementoredgeAdmin.onDocumentReady();
            });

            $(window).on('load', function() {
                ElementoredgeAdmin.onWindowLoad();
            });
        },

        /**
         * Document ready callback
         */
        onDocumentReady: function() {
            console.log('Elementor edge Admin initialized');
            this.initTabs();
            this.initTooltips();
        },

        /**
         * Window load callback
         */
        onWindowLoad: function() {
            this.hideLoadingOverlay();
        },

        /**
         * Initialize color pickers
         */
        initColorPickers: function() {
            if ($.fn.wpColorPicker) {
                $('.edge-color-picker').wpColorPicker({
                    change: function(event, ui) {
                        var element = event.target;
                        var color = ui.color.toString();
                        $(element).val(color).trigger('change');
                    }
                });
            }
        },

        /**
         * Initialize widget grid
         */
        initWidgetGrid: function() {
            var $widgetGrid = $('.edge-widgets-grid');

            if ($widgetGrid.length) {
                // Widget toggle functionality
                $widgetGrid.on('change', '.widget-toggle', function() {
                    var $this = $(this);
                    var $card = $this.closest('.widget-card');
                    var widgetKey = $this.data('widget');

                    if ($this.is(':checked')) {
                        $card.addClass('active');
                        ElementoredgeAdmin.saveWidgetState(widgetKey, true);
                    } else {
                        $card.removeClass('active');
                        ElementoredgeAdmin.saveWidgetState(widgetKey, false);
                    }
                });

                // Widget info modal
                $widgetGrid.on('click', '.widget-info', function(e) {
                    e.preventDefault();
                    var widgetName = $(this).data('widget-name');
                    var widgetDesc = $(this).data('widget-desc');
                    ElementoredgeAdmin.showWidgetInfo(widgetName, widgetDesc);
                });
            }
        },

        /**
         * Save widget state via AJAX
         */
        saveWidgetState: function(widgetKey, enabled) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'edge_save_widget_state',
                    widget_key: widgetKey,
                    enabled: enabled ? 1 : 0,
                    nonce: elementoredgeAdmin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        ElementoredgeAdmin.showNotice(ElementoredgeAdmin.strings.widget_added, 'success');
                    } else {
                        ElementoredgeAdmin.showNotice(ElementoredgeAdmin.strings.settings_error, 'error');
                    }
                },
                error: function() {
                    ElementoredgeAdmin.showNotice(ElementoredgeAdmin.strings.settings_error, 'error');
                }
            });
        },

        /**
         * Show widget info modal
         */
        showWidgetInfo: function(name, description) {
            var modalHtml = '<div class="edge-modal-overlay">' +
                '<div class="edge-modal">' +
                    '<div class="edge-modal-header">' +
                        '<h3>' + name + '</h3>' +
                        '<button class="edge-modal-close">&times;</button>' +
                    '</div>' +
                    '<div class="edge-modal-body">' +
                        '<p>' + description + '</p>' +
                    '</div>' +
                '</div>' +
            '</div>';

            $('body').append(modalHtml);

            // Close modal events
            $('.edge-modal-overlay').on('click', function(e) {
                if (e.target === this) {
                    $(this).remove();
                }
            });

            $('.edge-modal-close').on('click', function() {
                $('.edge-modal-overlay').remove();
            });
        },

        /**
         * Initialize admin tabs
         */
        initTabs: function() {
            var $tabs = $('.edge-admin-tabs');

            if ($tabs.length) {
                $tabs.on('click', '.tab-nav a', function(e) {
                    e.preventDefault();

                    var $this = $(this);
                    var target = $this.attr('href');

                    // Update active states
                    $this.closest('.tab-nav').find('a').removeClass('active');
                    $this.addClass('active');

                    // Show target content
                    $('.tab-content').removeClass('active');
                    $(target).addClass('active');

                    // Save active tab
                    localStorage.setItem('edge_active_tab', target);
                });

                // Restore active tab
                var activeTab = localStorage.getItem('edge_active_tab');
                if (activeTab && $(activeTab).length) {
                    $('.tab-nav a[href="' + activeTab + '"]').trigger('click');
                }
            }
        },

        /**
         * Initialize tooltips
         */
        initTooltips: function() {
            $('.edge-tooltip').on('mousedgenter', function() {
                var $this = $(this);
                var text = $this.data('tooltip');

                if (text) {
                    var $tooltip = $('<div class="edge-tooltip-popup">' + text + '</div>');
                    $('body').append($tooltip);

                    var offset = $this.offset();
                    $tooltip.css({
                        top: offset.top - $tooltip.outerHeight() - 5,
                        left: offset.left + ($this.outerWidth() / 2) - ($tooltip.outerWidth() / 2)
                    });
                }
            }).on('mouseleave', function() {
                $('.edge-tooltip-popup').remove();
            });
        },

        /**
         * Handle settings form
         */
        handleSettingsForm: function() {
            var $form = $('#edge-settings-form');

            if ($form.length) {
                $form.on('submit', function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    formData.append('action', 'edge_save_settings');
                    formData.append('nonce', elementoredgeAdmin.nonce);

                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            ElementoredgeAdmin.showLoading();
                        },
                        success: function(response) {
                            ElementoredgeAdmin.hideLoading();

                            if (response.success) {
                                ElementoredgeAdmin.showNotice(ElementoredgeAdmin.strings.settings_saved, 'success');
                            } else {
                                ElementoredgeAdmin.showNotice(response.data.message || ElementoredgeAdmin.strings.settings_error, 'error');
                            }
                        },
                        error: function() {
                            ElementoredgeAdmin.hideLoading();
                            ElementoredgeAdmin.showNotice(ElementoredgeAdmin.strings.settings_error, 'error');
                        }
                    });
                });
            }
        },

        /**
         * Show admin notice
         */
        showNotice: function(message, type) {
            type = type || 'info';

            var $notice = $('<div class="notice notice-' + type + ' is-dismissible">' +
                '<p>' + message + '</p>' +
                '<button type="button" class="notice-dismiss">' +
                    '<span class="scredgen-reader-text">Dismiss this notice.</span>' +
                '</button>' +
            '</div>');

            $('.wrap h1').after($notice);

            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                $notice.fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);

            // Manual dismiss
            $notice.on('click', '.notice-dismiss', function() {
                $notice.fadeOut(function() {
                    $(this).remove();
                });
            });
        },

        /**
         * Show loading overlay
         */
        showLoading: function() {
            if (!$('.edge-loading-overlay').length) {
                var $overlay = $('<div class="edge-loading-overlay">' +
                    '<div class="edge-spinner"></div>' +
                '</div>');

                $('body').append($overlay);
            }
        },

        /**
         * Hide loading overlay
         */
        hideLoading: function() {
            $('.edge-loading-overlay').remove();
        },

        /**
         * Hide initial loading overlay
         */
        hideLoadingOverlay: function() {
            $('.edge-initial-loading').fadeOut();
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        ElementoredgeAdmin.init();
    });

    // Export to global scope
    window.ElementoredgeAdmin = ElementoredgeAdmin;

})(jQuery);
