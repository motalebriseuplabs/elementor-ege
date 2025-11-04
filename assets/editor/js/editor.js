/**
 * Editor JavaScript for Elementor edge
 *
 * @package Elementoredge
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Editor Main Class
     */
    var ElementoredgeEditor = {

        /**
         * Translations
         */
        strings: {},

        /**
         * Initialize editor functionality
         */
        init: function() {
            this.loadTranslations();
            this.bindEvents();
            this.initCustomControls();
        },

        /**
         * Load translations
         */
        loadTranslations: function() {
            // Get localized strings from WordPress
            this.strings = (typeof elementoredgeEditor !== 'undefined' && elementoredgeEditor.strings) ? elementoredgeEditor.strings : {
                widget_title: 'Elementor edge Widget',
                widget_description: 'Advanced widget for Elementor',
                content_tab: 'Content',
                style_tab: 'Style',
                advanced_tab: 'Advanced',
                general_section: 'General',
                typography_section: 'Typography',
                spacing_section: 'Spacing',
                border_section: 'Border',
                background_section: 'Background'
            };
        },

        /**
         * Bind editor events
         */
        bindEvents: function() {
            // Wait for Elementor to be ready
            $(window).on('elementor:init', function() {
                ElementoredgeEditor.onElementorInit();
            });

            // Panel events
            elementor.hooks.addAction('panel/open_editor/widget', function(panel, model, view) {
                ElementoredgeEditor.onWidgetPanelOpen(panel, model, view);
            });

            // Preview events
            elementor.hooks.addAction('frontend/element_ready/global', function($scope) {
                ElementoredgeEditor.onElementReady($scope);
            });
        },

        /**
         * Elementor initialization callback
         */
        onElementorInit: function() {
            console.log('Elementor edge Editor initialized');
            this.addCustomCategories();
            this.registerCustomControls();
        },

        /**
         * Widget panel open callback
         */
        onWidgetPanelOpen: function(panel, model, view) {
            var widgetType = model.get('widgetType');

            if (widgetType && widgetType.startsWith('elementor-edge-')) {
                this.enhanceWidgetPanel(panel, model, view);
            }
        },

        /**
         * Element ready callback
         */
        onElementReady: function($scope) {
            var $widget = $scope.find('[class*="elementor-edge-"]');

            if ($widget.length) {
                this.initWidgetPreview($widget);
            }
        },

        /**
         * Add custom widget categories
         */
        addCustomCategories: function() {
            elementor.modules.controls.Manager.addControlType('elementor-edge-query',
                elementor.modules.controls.BaseData.extend({
                    onReady: function() {
                        ElementoredgeEditor.initQueryControl(this);
                    }
                })
            );

            elementor.modules.controls.Manager.addControlType('elementor-edge-image-choose',
                elementor.modules.controls.Choose.extend({
                    getControlValue: function() {
                        return this.ui.inputs.filter(':checked').val();
                    },
                    onReady: function() {
                        ElementoredgeEditor.initImageChooseControl(this);
                    }
                })
            );
        },

        /**
         * Register custom controls
         */
        registerCustomControls: function() {
            // Query control for advanced post selection
            this.registerQueryControl();

            // Image choose control for layout selection
            this.registerImageChooseControl();

            // Advanced gradient control
            this.registerGradientControl();
        },

        /**
         * Register query control
         */
        registerQueryControl: function() {
            var QueryControlView = elementor.modules.controls.BaseData.extend({
                onReady: function() {
                    this.ui.select = this.$el.find('select');
                    this.ui.input = this.$el.find('input');

                    this.bindEvents();
                    this.loadOptions();
                },

                bindEvents: function() {
                    var self = this;

                    this.ui.select.on('change', function() {
                        self.saveValue();
                        self.loadSubOptions();
                    });

                    this.ui.input.on('input change', function() {
                        self.saveValue();
                    });
                },

                loadOptions: function() {
                    var self = this;
                    var queryType = this.model.get('query_type') || 'posts';

                    $.ajax({
                        url: ajaxurl,
                        data: {
                            action: 'edge_get_query_options',
                            query_type: queryType,
                            nonce: elementoredgeEditor.nonce
                        },
                        success: function(response) {
                            if (response.success) {
                                self.updateOptions(response.data);
                            }
                        }
                    });
                },

                updateOptions: function(options) {
                    var $select = this.ui.select;
                    $select.empty();

                    $.each(options, function(value, label) {
                        $select.append('<option value="' + value + '">' + label + '</option>');
                    });
                },

                saveValue: function() {
                    var value = {
                        type: this.ui.select.val(),
                        count: this.ui.input.val()
                    };

                    this.setValue(value);
                }
            });

            elementor.addControlView('elementor-edge-query', QueryControlView);
        },

        /**
         * Register image choose control
         */
        registerImageChooseControl: function() {
            var ImageChooseControlView = elementor.modules.controls.Choose.extend({
                onReady: function() {
                    this.ui.choices = this.$el.find('.elementor-choices input');
                    this.ui.labels = this.$el.find('.elementor-choices label');

                    this.bindEvents();
                },

                bindEvents: function() {
                    var self = this;

                    this.ui.choices.on('change', function() {
                        self.updateSelection();
                        self.saveValue();
                    });
                },

                updateSelection: function() {
                    var selected = this.ui.choices.filter(':checked').val();

                    this.ui.labels.removeClass('selected');
                    this.ui.choices.filter('[value="' + selected + '"]')
                        .closest('label').addClass('selected');
                },

                saveValue: function() {
                    var value = this.ui.choices.filter(':checked').val();
                    this.setValue(value);
                }
            });

            elementor.addControlView('elementor-edge-image-choose', ImageChooseControlView);
        },

        /**
         * Register gradient control
         */
        registerGradientControl: function() {
            var GradientControlView = elementor.modules.controls.BaseMultiple.extend({
                onReady: function() {
                    this.initGradientPicker();
                },

                initGradientPicker: function() {
                    var self = this;
                    var $container = this.$el.find('.edge-gradient-picker');

                    if ($container.length) {
                        // Initialize gradient picker logic here
                        this.createGradientInterface($container);
                    }
                },

                createGradientInterface: function($container) {
                    // Create gradient picker interface
                    var html = '<div class="edge-gradient-controls">' +
                        '<div class="edge-gradient-preview"></div>' +
                        '<div class="edge-gradient-stops"></div>' +
                        '<div class="edge-gradient-angle">' +
                            '<input type="range" min="0" max="360" value="90" class="edge-angle-slider">' +
                            '<span class="edge-angle-value">90°</span>' +
                        '</div>' +
                    '</div>';

                    $container.html(html);
                    this.bindGradientEvents($container);
                },

                bindGradientEvents: function($container) {
                    var self = this;

                    $container.find('.edge-angle-slider').on('input', function() {
                        var angle = $(this).val();
                        $container.find('.edge-angle-value').text(angle + '°');
                        self.updateGradient();
                    });
                },

                updateGradient: function() {
                    // Update gradient preview and save value
                    var gradient = this.buildGradientString();
                    this.$el.find('.edge-gradient-preview').css('background', gradient);
                    this.setValue(gradient);
                },

                buildGradientString: function() {
                    var angle = this.$el.find('.edge-angle-slider').val();
                    return 'linear-gradient(' + angle + 'deg, #ff0000 0%, #0000ff 100%)';
                }
            });

            elementor.addControlView('elementor-edge-gradient', GradientControlView);
        },

        /**
         * Initialize custom controls
         */
        initCustomControls: function() {
            // Initialize query controls
            this.initQueryControls();

            // Initialize image choose controls
            this.initImageChooseControls();
        },

        /**
         * Initialize query controls
         */
        initQueryControls: function() {
            $(document).on('change', '.elementor-control-type-elementor-edge-query select', function() {
                var $this = $(this);
                var $control = $this.closest('.elementor-control');
                var value = $this.val();

                $control.addClass('edge-loading');

                // Simulate loading delay
                setTimeout(function() {
                    $control.removeClass('edge-loading');
                }, 1000);
            });
        },

        /**
         * Initialize image choose controls
         */
        initImageChooseControls: function() {
            $(document).on('change', '.elementor-control-type-elementor-edge-image-choose input', function() {
                var $this = $(this);
                var $control = $this.closest('.elementor-control');
                var $options = $control.find('.image-option');

                $options.removeClass('selected');
                $this.closest('.image-option').addClass('selected');
            });
        },

        /**
         * Enhance widget panel
         */
        enhanceWidgetPanel: function(panel, model, view) {
            var $panelContent = panel.$el.find('.elementor-panel-content');

            // Add widget info notice
            var widgetType = model.get('widgetType');
            var widgetTitle = this.getWidgetTitle(widgetType);

            var notice = '<div class="elementor-edge-widget-notice">' +
                '<span class="notice-icon">ⓘ</span>' +
                'You are editing: <strong>' + widgetTitle + '</strong>' +
            '</div>';

            $panelContent.prepend(notice);

            // Initialize panel-specific functionality
            this.initPanelControls($panelContent);
        },

        /**
         * Get widget title by type
         */
        getWidgetTitle: function(widgetType) {
            var titles = {
                'elementor-edge-hello': 'Hello Widget',
                'elementor-edge-progress': 'Progress Bar',
                'elementor-edge-counter': 'Counter',
                'elementor-edge-testimonials': 'Testimonials'
            };

            return titles[widgetType] || 'Elementor edge Widget';
        },

        /**
         * Initialize panel controls
         */
        initPanelControls: function($panel) {
            // Color pickers
            $panel.find('.edge-color-control').each(function() {
                var $input = $(this).find('input[type="text"]');

                if ($input.length && typeof $.fn.wpColorPicker !== 'undefined') {
                    $input.wpColorPicker();
                }
            });

            // Range sliders
            $panel.find('.edge-range-control').each(function() {
                var $slider = $(this).find('input[type="range"]');
                var $output = $(this).find('.range-value');

                $slider.on('input', function() {
                    $output.text($(this).val());
                });
            });
        },

        /**
         * Initialize widget preview
         */
        initWidgetPreview: function($widget) {
            var widgetClass = $widget.attr('class');
            var match = widgetClass.match(/elementor-edge-(\w+)/);

            if (match) {
                var widgetType = match[1];
                this.initSpecificWidget($widget, widgetType);
            }
        },

        /**
         * Initialize specific widget preview
         */
        initSpecificWidget: function($widget, type) {
            switch (type) {
                case 'hello':
                    this.initHelloWidget($widget);
                    break;
                case 'progress':
                    this.initProgressWidget($widget);
                    break;
                case 'counter':
                    this.initCounterWidget($widget);
                    break;
                case 'testimonials':
                    this.initTestimonialsWidget($widget);
                    break;
            }
        },

        /**
         * Initialize hello widget preview
         */
        initHelloWidget: function($widget) {
            var $button = $widget.find('.edge-hello-button');

            $button.on('click', function(e) {
                e.preventDefault();
                console.log('Hello widget clicked in editor preview');
            });
        },

        /**
         * Initialize progress widget preview
         */
        initProgressWidget: function($widget) {
            var $progressBar = $widget.find('.edge-progress-fill');
            var percentage = $progressBar.data('percentage') || 0;

            // Animate in editor preview
            $progressBar.css('width', '0%').animate({
                width: percentage + '%'
            }, 1000);
        },

        /**
         * Initialize counter widget preview
         */
        initCounterWidget: function($widget) {
            var $number = $widget.find('.edge-counter-number');
            var target = parseInt($number.data('target')) || 0;

            // Animate counter in editor preview
            $({ value: 0 }).animate({ value: target }, {
                duration: 1500,
                step: function() {
                    $number.text(Math.floor(this.value));
                },
                complete: function() {
                    $number.text(target);
                }
            });
        },

        /**
         * Initialize testimonials widget preview
         */
        initTestimonialsWidget: function($widget) {
            var $items = $widget.find('.edge-testimonial-item');

            if ($items.length > 1) {
                var currentIndex = 0;

                setInterval(function() {
                    $items.removeClass('active');
                    currentIndex = (currentIndex + 1) % $items.length;
                    $items.eq(currentIndex).addClass('active');
                }, 3000);
            }
        }
    };

    // Initialize when Elementor is loaded
    $(window).on('elementor:init', function() {
        ElementoredgeEditor.init();
    });

    // Export to global scope
    window.ElementoredgeEditor = ElementoredgeEditor;

})(jQuery);
