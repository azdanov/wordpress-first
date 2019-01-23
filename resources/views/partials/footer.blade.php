<footer class="footer content-info my-8">
  <div class="container">
    <div>
      @php(dynamic_sidebar('sidebar-footer'))
    </div>
    <div>
      @if(has_nav_menu('social_links'))
        {!! wp_nav_menu(['theme_location' => 'social_links', 'menu_class' => 'social', 'container' => '']) !!}
      @endif
    </div>
    <p class="mt-6 text-center font-sans text-grey-darker text-base">© {{ date('Y') }}</p>
  </div>
</footer>
