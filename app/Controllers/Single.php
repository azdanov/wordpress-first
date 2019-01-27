<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Post;
use function comments_open;
use function get_comments_number;
use function get_edit_post_link;
use function get_the_category_list;
use function get_the_modified_time;
use function get_the_post_navigation;
use function get_the_tag_list;
use function get_the_time;
use function post_password_required;

final class Single extends Controller
{
    public static function canEditPost(WP_Post $post): bool
    {
        return (bool)get_edit_post_link($post->ID);
    }

    public function categoriesList(): string
    {
        return get_the_category_list();
    }

    public function tagsList(): string
    {
        return get_the_tag_list() ?: '';
    }

    public function isPostModified(): bool
    {
        return get_the_time('U') !== get_the_modified_time('U');
    }

    public function canDisplayCommentsMeta(): bool
    {
        return (!post_password_required() && comments_open()) || get_comments_number();
    }

    public function postNavigation(): string
    {
        return get_the_post_navigation([
            'next_text' => '<span class="nav-meta">' . __('Next', 'first') . '</span> ' .
                '<span class="nav-title">%title</span>',
            'prev_text' => '<span class="nav-meta">' . __('Previous', 'first') . '</span> ' .
                '<span class="nav-title">%title</span>',
        ]);
    }
}
