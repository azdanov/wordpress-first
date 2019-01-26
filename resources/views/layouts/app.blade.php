<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')

<body @php(body_class())>
@php(do_action('get_header'))
@include('partials.header')

<div class="wrap container" role="document">
  <div class="content {{$show_blog_sidebar ? 'flex flex-wrap' : ''}}">
    <main class="main md:w-3/4 mx-auto">
      @yield('content')
    </main>
    @if ($show_blog_sidebar)
      <aside class="sidebar md:w-1/4 mt-6 md:mt-0 pl-10">
        @include('partials.sidebar')
      </aside>
    @endif
  </div>
</div>

@php(do_action('get_footer'))
@include('partials.footer')
@php(wp_footer())

</body>
</html>
