@php
/** @var string $categories_list */
/** @var string $tags_list */
@endphp
<article @php(post_class())>
  <header class="mb-1">
    @isset ($categories_list)
      {!! $categories_list !!}
    @endisset
    <h1 class="entry-title mt-1 mb-2">{{ get_the_title() }}</h1>
    @isset ($tags_list)
      <div class="post-tags mb-1">
        <span class="font-sans text-grey-darkest mr-2">{{ __('Tagged', 'first') }}</span>
        {!! $tags_list !!}
      </div>
    @endisset
    @include('partials/entry-meta')
  </header>
  <div class="entry-content">
    @php(the_content())
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav">' . __('Pages:', 'first'), 'after' => '</nav>']) !!}
    @isset ($post_navigation)
      {!! $post_navigation !!}
    @endisset
  </footer>
  @php(comments_template('/partials/comments.blade.php'))
</article>
