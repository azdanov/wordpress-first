@php
  /** @var string $categories_list */
  /** @var string $tags_list */
@endphp

<article @php(post_class())>
  <header class="mb-1">
    <h1 class="entry-title mt-1 mb-2">{{ get_the_title() }}</h1>
    @include('partials/entry-meta')
  </header>
  <div class="entry-content">
    @php(the_content())
  </div>
  <footer class="entry-footer">
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav">' . __('Pages:', 'first'), 'after' => '</nav>']) !!}
    <div class="mt-8">
      @isset ($categories_list)
        {!! $categories_list !!}
      @endisset
      @isset ($tags_list)
        <div class="post-tags">
          {!! $tags_list !!}
        </div>
      @endisset
    </div>
    @isset ($post_navigation)
      {!! $post_navigation !!}
    @endisset
  </footer>
  @php(comments_template('/partials/comments.blade.php'))
</article>
