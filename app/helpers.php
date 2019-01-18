<?php

declare(strict_types=1);

namespace App;

use Roots\Sage\Config;
use Roots\Sage\Container;
use function collect;
use function implode;
use function is_array;
use function ltrim;
use function preg_replace;
use function strpos;

// phpcs:disable Squiz.Strings.DoubleQuoteUsage.ContainsVar, Squiz.Functions.GlobalFunction.Found

/**
 * Get the sage container.
 *
 * @param mixed[] $parameters
 *
 * @return Container|mixed
 */
function sage(?string $abstract = null, array $parameters = [], ?Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }

    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @see https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 *
 * @param mixed[]|string $key
 * @param mixed          $default
 *
 * @return mixed|Config
 */
function config($key = null, $default = null)
{
    if ($key === null) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }

    return sage('config')->get($key, $default);
}

/**
 * @param mixed[] $data
 */
function template(string $file, array $data = []): string
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view.
 *
 * @param mixed[] $data
 */
function template_path(string $file, array $data = []): string
{
    return sage('blade')->compiledPath($file, $data);
}

function asset_path(string $asset): string
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 *
 * @return mixed[]
 */
function filter_templates($templates): array
{
    $paths = apply_filters('sage/filter_templates/paths', ['views', 'resources/views']);
    $paths_pattern = '#^(' . implode('|', $paths) . ')/#';

    return collect($templates)
        ->map(static function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(static function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(static function ($path) use ($template) {
                    return ["{$path}/{$template}.blade.php", "{$path}/{$template}.php"];
                })
                ->concat(["{$template}.blade.php", "{$template}.php"]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 *
 * @return string Location of the template
 */
function locate_template($templates): string
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar.
 *
 * @return mixed|bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);

    return $display;
}
