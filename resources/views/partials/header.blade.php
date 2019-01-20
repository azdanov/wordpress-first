@if(is_front_page() && get_header_image())
  <figure class="header-image overflow-hidden">
    <a href="{{ home_url( '/' ) }}" rel="home" class="border-none">
      <img src="@php(header_image())" class="block w-screen"
           width="{{ get_custom_header()->width }}"
           height="{{ get_custom_header()->height }}" alt="">
    </a>
  </figure>
@endif

<header class="banner py-5 mb-3">
  <div class="container flex flex-wrap justify-between items-center">
    <div class="leading-none flex items-center">
      @if(has_custom_logo())
        <div class="mr-2">
          @php(the_custom_logo())
        </div>
      @endif
      <div>
        <a class="text-3xl text-black border-none" href="{{ home_url('/') }}">{{ $site_name }}</a>
        <p class="text-grey-darkest mb-0 font-sans">{{ $site_description }}</p>
      </div>
    </div>
    <button
      id="menu-toggle"
      class="lg:hidden flex items-center px-3 py-2 border text-grey-darker border-grey-darker hover:text-grey hover:border-grey">
      <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <title>Menu</title>
        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
      </svg>
    </button>
    <nav class="hidden lg:block w-full lg:w-auto">
      @if(has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container' => '']) !!}
      @endif
    </nav>
  </div>
</header>
