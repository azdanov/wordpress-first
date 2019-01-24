<?php

declare(strict_types=1);

namespace App;

use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Container;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;
use function add_editor_style;
use function add_theme_support;
use function file_exists;
use function register_nav_menus;
use function register_sidebar;
use function time;
use function wp_deregister_script;
use function wp_enqueue_script;
use function wp_enqueue_style;
use function wp_mkdir_p;

/**
 * @see https://wordpress.stackexchange.com/questions/211701/what-does-wp-embed-min-js-do-in-wordpress-4-4
 */
add_action('init', static function (): void {
    wp_deregister_script('wp-embed');
});

/**
 * Theme assets.
 */
add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, time());
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], time(), true);
}, 100);

/**
 * Theme setup.
 */
add_action('after_setup_theme', static function (): void {
    /**
     * Enable features from Soil when plugin is activated.
     *
     * @see https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title.
     *
     * @see https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus.
     *
     * @see https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Header Navigation', 'first'),
    ]);

    register_nav_menus([
        'social_links' => __('Social Links', 'first'),
    ]);

    /**
     * Enable post thumbnails.
     *
     * @see https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support.
     *
     * @see https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support(
        'html5',
        ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']
    );

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @see https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor.
     *
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));

    /**
     * Add custom header support.
     *
     * @see https://developer.wordpress.org/reference/functions/add_theme_support/#custom-header
     */
    add_theme_support(
        'custom-header',
        apply_filters(
            'sage/display_custom_header',
            [
                'default-image' => '',
                'default-text-color' => 'ffffff',
                'width' => 2000,
                'height' => 850,
                'flex-height' => true,
            ]
        )
    );

    /**
     * Add custom logo support.
     *
     * @see https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        [
            'width' => 180,
            'height' => 180,
            'flex-width' => true,
        ]
    );
}, 20);

/**
 * Register sidebars.
 */
add_action('widgets_init', static function (): void {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];
    register_sidebar([
        'name' => __('Blog', 'first'),
        'id' => 'sidebar-blog',
    ] + $config);
    register_sidebar([
        'name' => __('Footer', 'first'),
        'id' => 'sidebar-footer',
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials.
 */
add_action('the_post', static function ($post): void {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options.
 */
add_action('after_setup_theme', static function (): void {
    /**
     * Add JsonManifest to Sage container.
     */
    sage()->singleton('sage.assets', static function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container.
     */
    sage()->singleton('sage.blade', static function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();

        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive.
     */
    sage('blade')->compiler()->directive('asset', static function ($asset) {
        // phpcs:ignore Squiz.Strings.DoubleQuoteUsage.ContainsVar
        return '<?= ' . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});
