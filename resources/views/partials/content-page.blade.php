<article @php(post_class())>
  <div class="page-content">
    @php(the_content())
  </div>
  <footer class="page-footer">
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'first'), 'after' => '</p></nav>']) !!}
  </footer>
</article>
