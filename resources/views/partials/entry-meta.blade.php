<section class="uppercase text-xs text-grey-dark pl-1">
  <time datetime="{{ get_post_time('c', true) }}">
    {{ get_the_date() }}
  </time>

  @if (isset($is_post_modified) && $is_post_modified)
    <time class="hidden" datetime="{{ get_the_modified_date('c', true) }}">
      {{ get_the_modified_date() }}
    </time>
  @endif

  @if (isset($can_display_comments_meta) && $can_display_comments_meta)
    <span class="mx-1 select-none text-grey">&middot;</span>
    @php(comments_popup_link(false, false, false, 'comment_meta'))
  @endif

  @if (App\Controllers\Single::canEditPost($post))
    <span class="mx-1 select-none text-grey">&middot;</span>
    @php(edit_post_link(__('Edit Post', 'first')))
  @endif

  <p class="text-xs">
    {{ __('By', 'first') }}
    <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author"
       class="text-xs text-grey-darker hover:border-grey-darker">
      {{ get_the_author() }}
    </a>
  </p>
</section>
