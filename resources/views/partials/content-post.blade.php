<article @php(post_class())>
  <header>
    <h2 class="entry-title"><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h2>
    @include('partials/entry-meta')
  </header>
  @if(has_post_thumbnail())
    <figure class="my-3 featured-image index">
      <a href="{{ get_permalink() }}">
        @php(the_post_thumbnail('first-index'))
      </a>
    </figure>
  @endif
  <div class="entry-summary">
    @php(the_excerpt())
  </div>
</article>
