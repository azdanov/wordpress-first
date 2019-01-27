<article @php(post_class())>
  <div class="page-content">
    @php(the_content())
  </div>
  <?php
    $links = wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'first'), 'after' => '</p></nav>']);
  ?>
  @if ($links)
    <footer class="page-footer">
      {!! $links !!}
    </footer>
  @endif
  @php(comments_template('/partials/comments.blade.php'))
</article>
