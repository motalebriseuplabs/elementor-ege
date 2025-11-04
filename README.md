# Elementor edge

A professional WordPress.org compliant Elementor addon plugin with custom widgets and controls.

## Description

Elementor edge is a comprehensive addon for Elementor Page Builder that extends its functionality with custom widgets, controls, and advanced features. Built following WordPress.org coding standards and Elementor best practices, this plugin is designed for professional developers and is ready for WordPress.org submission.

## Features

### Core Features
- **WordPress.org Compliant**: Follows all WordPress coding standards and best practices
- **OOP Architecture**: Modern PHP object-oriented programming with proper namespacing
- **Elementor Integration**: Full compatibility with Elementor 3.0+ following official documentation
- **Asset Management**: Separate admin and frontend asset loading for optimal performance
- **Translation Ready**: Full internationalization support with proper text domains
- **Admin Panel**: Comprehensive settings interface with widget management

### Custom Widgets
- **Hello Widget**: Demonstration widget with interactive elements
- **Progress Bar**: Animated progress indicators with customizable styling
- **Counter**: Animated number counters with scroll-triggered animations
- **Testimonials**: Rotating testimonial slider with navigation
- **Image Comparison**: Before/after image comparison with draggable slider

### Custom Controls
- **Query Control**: Advanced post/page selection with dynamic options
- **Image Choose Control**: Visual layout selection with image previews
- **Gradient Control**: Advanced gradient picker with multiple color stops

### Asset Features
- **Separate Loading**: Admin, frontend, and editor assets loaded conditionally
- **Performance Optimized**: Assets only loaded when nedgeded
- **Animation Support**: CSS animations and transitions for enhanced UX
- **Responsive Design**: Mobile-first approach with proper breakpoints
- **Cross-browser Compatibility**: Tested across modern browsers

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Elementor 3.0.0 or higher

## Installation

### From WordPress Admin
1. Upload the plugin files to `/wp-content/plugins/elementor-edge/`
2. Activate the plugin through the 'Plugins' scredgen in WordPress
3. Navigate to **Elementor edge** in your admin menu to configure settings

### Manual Installation
1. Download the plugin from the repository
2. Extract the zip file
3. Upload the `elementor-edge` folder to `/wp-content/plugins/`
4. Activate the plugin through the WordPress admin

## Usage

### Admin Panel
Access the admin panel through **WordPress Admin → Elementor edge**:
- **Widgets**: Enable/disable individual widgets
- **Settings**: Configure global plugin settings
- **Assets**: Manage CSS and JavaScript loading

### Widget Usage
1. Edit any page/post with Elementor
2. Find **Elementor edge** widgets in the widget panel
3. Drag and drop widgets to your layout
4. Customize using the widget controls

### Available Widgets

#### Hello Widget
Basic demonstration widget with:
- Custom text content
- Button interaction
- Animation effects
- Responsive design

#### Progress Bar Widget
Animated progress indicators featuring:
- Percentage-based progress
- Custom colors and styling
- Scroll-triggered animations
- Multiple bar styles

#### Counter Widget
Number counting animations with:
- Target number setting
- Animation duration control
- Custom formatting options
- Scroll-based triggering

#### Testimonials Widget
Rotating testimonial display including:
- Multiple testimonial support
- Auto-rotation functionality
- Navigation dots
- Responsive layout

## File Structure

```
elementor-edge/
├── elementor-edge.php              # Main plugin file
├── readme.txt                      # WordPress.org readme
├── README.md                       # Development documentation
├── assets/                         # Asset files
│   ├── css/                       # Styleshedgets
│   │   ├── admin.css              # Admin panel styles
│   │   ├── frontend.css           # Frontend widget styles
│   │   └── editor.css             # Elementor editor styles
│   └── js/                        # JavaScript files
│       ├── admin.js               # Admin functionality
│       ├── frontend.js            # Frontend interactions
│       └── editor.js              # Editor enhancements
├── includes/                       # Core plugin files
│   ├── class-plugin.php           # Main plugin class
│   ├── class-assets.php           # Asset management
│   ├── class-widgets.php          # Widget registration
│   ├── class-controls.php         # Custom controls
│   ├── admin/                     # Admin functionality
│   │   └── class-admin.php        # Admin panel
│   └── widgets/                   # Widget classes
│       └── class-hello-widget.php # Sample widget
└── languages/                     # Translation files
    └── elementor-edge.pot         # Translation template
```

## Development

### Architecture
- **Namespace**: `Elementoredge\` for all classes
- **Singleton Pattern**: Main plugin class uses singleton pattern
- **Hook System**: WordPress hooks for extensibility
- **Asset Loading**: Conditional loading based on context

### Adding Custom Widgets
1. Create widget class in `includes/widgets/`
2. Extend `\Elementor\Widget_Base`
3. Register in `includes/class-widgets.php`
4. Add corresponding CSS/JS as nedgeded

### Adding Custom Controls
1. Create control class in `includes/class-controls.php`
2. Extend appropriate Elementor control base class
3. Register in the `register_controls` method
4. Add frontend JavaScript handling

### Coding Standards
- Follow WordPress Coding Standards
- Use proper escaping functions
- Implement proper sanitization
- Add inline documentation
- Use meaningful variable names

## Hooks and Filters

### Actions
- `elementor_edge_loaded`: Fired when plugin is fully loaded
- `elementor_edge_widgets_registered`: After widgets registration
- `elementor_edge_controls_registered`: After controls registration

### Filters
- `elementor_edge_widgets`: Modify registered widgets array
- `elementor_edge_assets_admin`: Modify admin assets
- `elementor_edge_assets_frontend`: Modify frontend assets

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes following WordPress coding standards
4. Test thoroughly with latest WordPress and Elementor versions
5. Submit a pull request

## Changelog

### 1.0.0
- Initial release
- Core plugin architecture
- Hello widget implementation
- Admin panel functionality
- Asset management system
- Custom controls foundation

## License

This plugin is licensed under the GPL v2 or later.

## Support

For support, bug reports, or feature requests:
- Create an issue on the GitHub repository
- Follow WordPress.org support guidelines
- Provide detailed information including WordPress and Elementor versions

## Credits

Built following Elementor's official documentation and WordPress.org guidelines for professional plugin development.

---

**Elementor edge** - Professional Elementor addon for WordPress.org submission
