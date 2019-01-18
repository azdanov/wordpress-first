<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;
use function get_bloginfo;
use function get_search_query;
use function get_the_archive_title;
use function get_the_title;
use function is_404;
use function is_archive;
use function is_home;
use function is_search;
use function sprintf;

final class App extends Controller
{
    public function siteName(): string
    {
        return get_bloginfo('name');
    }

    public function siteDescription(): string
    {
        return get_bloginfo('description');
    }

    public static function title(): string
    {
        if (is_home()) {
            $home = get_option('page_for_posts', true);
            if ($home) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'first');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'first'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'first');
        }

        return get_the_title();
    }
}
