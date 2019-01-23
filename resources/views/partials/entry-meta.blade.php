<section class="font-sans uppercase text-xs text-grey-dark">
  <time datetime="{{ get_post_time('c', true) }}">
    {{ get_the_date() }}
  </time>

  @isset ($is_post_modified)
    <time class="hidden" datetime="{{ get_the_modified_date('c', true) }}">
      {{ get_the_modified_date() }}
    </time>
  @endisset

  @isset ($can_display_comments_meta)
    <span class="mx-1 select-none text-grey">&middot;</span>
    @php(comments_popup_link(false, false, false, 'comment_meta'))
  @endisset

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
