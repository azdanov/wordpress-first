<?php

declare(strict_types=1);

namespace App;

use const PHP_INT_MAX;
use function array_filter;
use function array_map;
use function basename;
use function collect;
use function do_action;
use function get_body_class;
use function get_permalink;
use function get_stylesheet_directory;
use function get_template_directory;
use function in_array;
use function is_front_page;
use function is_page;
use function is_single;
use function ob_get_clean;
use function ob_start;
use function preg_replace;
use function remove_all_actions;
use function sprintf;
use function str_replace;

/**
 * Add <body> classes.
 */
add_filter('body_class', static function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || (is_page() && !is_front_page())) {
        if (!in_array(basename(get_permalink()), $classes, true)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(static function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt.
 */
add_filter('excerpt_more', static function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files.
 */
collect([
    'index',
    '404',
    'archive',
    'author',
    'category',
    'tag',
    'taxonomy',
    'date',
    'home',
    'frontpage',
    'page',
    'paged',
    'search',
    'single',
    'singular',
    'attachment',
])->map(static function ($type): void {
    add_filter($type . '_template_hierarchy', __NAMESPACE__ . '\\filter_templates');
});

/**
 * Render page using Blade.
 */
add_filter('template_include', static function ($template) {
    collect(['get_header', 'wp_head'])->each(static function ($tag): void {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, static function () use ($output): void {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(static function ($data, $class) use ($template) {
        return apply_filters(sprintf('sage/template/%s/data', $class), $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);

        return get_stylesheet_directory() . '/index.php';
    }

    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php.
 */
add_filter('comments_template', static function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(static function (
        $data,
        $class
    ) use ($comments_template) {
        return apply_filters(sprintf('sage/template/%s/data', $class), $data, $comments_template);
    }, []);

    $theme_template = locate_template(['views/' . $comments_template, $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);

        return get_stylesheet_directory() . '/index.php';
    }

    return $comments_template;
}, 100);
