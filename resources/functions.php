<?php

declare(strict_types=1);

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Do not edit anything in this file unless you know what you're doing
 */

// phpcs:disable Squiz.Strings.DoubleQuoteUsage.ContainsVar, Squiz.Functions.GlobalFunction.Found

/**
 * Helper function for prettying up errors
 *
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = static function ($message, $subtitle = '', $title = ''): void {
    $title = $title ?: __('Sage &rsaquo; Error', 'first');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', PHP_VERSION, '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'first'), __('Invalid PHP version', 'first'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'first'), __('Invalid WordPress version', 'first'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists(Container::class)) {
    $composer = __DIR__ . '/../vendor/autoload.php';
    if (!file_exists($composer)) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'first'),
            __('Autoloader not found.', 'first')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(static function ($file) use ($sage_error): void {
    $file = "../app/{$file}.php";
    if (locate_template($file, true)) {
        return;
    }

    $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'first'), $file), 'File not found');
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    '\add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', static function () {
        return new Config([
            'assets' => require dirname(__DIR__) . '/config/assets.php',
            'theme' => require dirname(__DIR__) . '/config/theme.php',
            'view' => require dirname(__DIR__) . '/config/view.php',
        ]);
    }, true);
