<?php

declare(strict_types=1);

namespace App;

use WP_Customize_Manager;
use function bloginfo;
use function wp_enqueue_script;

/**
 * Theme customizer
 */
add_action('customize_register', static function (WP_Customize_Manager $wp_customize): void {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => static function (): void {
            bloginfo('name');
        },
    ]);

    // Remove colors
    $wp_customize->remove_section('colors');

    // Hide custom css
    $wp_customize->remove_section('custom_css');
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', static function (): void {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});
