@php
  /** @var string $categories_list */
  /** @var string $tags_list */
@endphp

<article @php(post_class())>
  <section>
    <header class="mb-1">
      <h1 class="entry-title mt-1 mb-2">{{ get_the_title() }}</h1>
      @include('partials/entry-meta')
    </header>
    <div class="flex">
      <div class="entry-content">
        @php(the_content())
      </div>
    </div>
    <footer class="entry-footer">
      {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav">' . __('Pages:', 'first'), 'after' => '</nav>']) !!}
      <div class="mt-8">
        @if ($categories_list)
          {!! $categories_list !!}
        @endif
        @if ($tags_list)
          <div class="post-tags">
            {!! $tags_list !!}
          </div>
        @endif
      </div>
      @if ($post_navigation)
        {!! $post_navigation !!}
      @endif
    </footer>
    @php(comments_template('/partials/comments.blade.php'))
  </section>
</article>
