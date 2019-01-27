@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="search">
    @if (!have_posts())
      <p class="mb-1">
        {{ __('Sorry, no results were found.', 'first') }}
      </p>
      <p class="mb-5">
        {{ __('Try searching again with different keywords.', 'first') }}
      </p>
      {!! get_search_form() !!}
    @endif

    @while(have_posts())
      @php(the_post())
      @include('partials.content-search')
    @endwhile

    {!! get_the_posts_navigation() !!}
  </div>
@endsection
