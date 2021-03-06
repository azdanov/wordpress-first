@php
  if (post_password_required()) {
    return;
  }
@endphp

@if(comments_open() && (int) get_comments_number() !== 0)
  <section id="comments" class="comments">
    @if (have_comments())
      <h2>
        {!! sprintf(_nx('One comment', '%1$s comments', get_comments_number(), 'comments title', 'first'), number_format_i18n(get_comments_number())) !!}
      </h2>

      <ol class="comment-list">
        {!! wp_list_comments([
          'style' => 'ol',
          'short_ping' => true,
          'avatar_size' => 96 ]) !!}
      </ol>

      @if (get_comment_pages_count() > 1 && get_option('page_comments'))
        <nav>
          <ul class="pager">
            @if (get_previous_comments_link())
              <li class="previous">
                @php(previous_comments_link(__('Older comments', 'first')))
              </li>
            @endif
            @if (get_next_comments_link())
              <li class="next">
                @php(next_comments_link(__('Newer comments', 'first')))
              </li>
            @endif
          </ul>
        </nav>
      @endif
    @endif

    @if (!comments_open() && (int) get_comments_number() !== 0 && post_type_supports(get_post_type(), 'comments'))
      <div class="my-3">
        {{ __('Comments are closed.', 'first') }}
      </div>
    @endif

    @php(comment_form())
  </section>
@endif
