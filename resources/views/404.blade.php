@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <p>
      {{ __('Sorry, but the page you were trying to view does not exist.', 'first') }}
    </p>
    <p class="mb-5">
      {{ __('Try using the search:', 'first') }}
    </p>
    @php(get_search_form())
  @endif
@endsection
