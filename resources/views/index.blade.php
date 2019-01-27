@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div>
      {{ __('Sorry, no results were found.', 'first') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @while (have_posts())
    @php(the_post())
    @include('partials.content-'.get_post_type())
  @endwhile

  {!! $get_pagination !!}
@endsection
