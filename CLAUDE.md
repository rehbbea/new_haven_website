# CLAUDE.md - WordPress Theme Development Guidelines

## Commands
- **Development**: `wp-cli server` (or use installed web server)
- **Debug Mode**: Set `WP_DEBUG` to `true` in wp-config.php
- **Code Check**: `php -l filename.php` to check for syntax errors
- **Test Site**: Visit site homepage and navigate through pages

## Coding Standards
- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- Use proper prefixing for functions/classes (e.g., `eldritch_function_name`)
- Include docblocks for functions with `@param` and `@return` tags
- Indentation: Tabs (not spaces)
- Array syntax: Use `array()` not `[]` for compatibility
- Naming: snake_case for functions, PascalCase for classes
- Error handling: Check with `is_wp_error()` and handle gracefully
- Sanitize inputs with WordPress functions (e.g., `sanitize_text_field()`)
- Escape outputs with WordPress functions (e.g., `esc_html()`, `esc_url()`)
- Use WordPress hooks system (actions/filters) for modifications