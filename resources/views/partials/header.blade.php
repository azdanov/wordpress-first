@if(is_front_page() && get_header_image())
  <figure class="header-image">
    <a href="{{ home_url( '/' ) }}" rel="home" class="border-none">
      <img src="@php(header_image())" class="block w-screen"
           width="{{ get_custom_header()->width }}"
           height="{{ get_custom_header()->height }}" alt="">
    </a>
  </figure>
@endif

<header class="banner">
  <div class="container flex justify-between items-center">
    <div class="leading-none">
      <a class="brand" href="{{ home_url('/') }}">{{ $site_name }}</a>
      <p class="description">{{ $site_description }}</p>
    </div>
    @if(has_nav_menu('primary_navigation'))
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container' => 'nav']) !!}
    @endif
  </div>
</header>
