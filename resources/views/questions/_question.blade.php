<div class="media post">
    <div class="d-flex flex-column counters">
        <div class="votes">
            <strong>{{ $question->votes_count }}</strong> {{ str_plural('vote', $question->votes_count) }}
        </div>

        <div class="status {{ $question->status_getter }}">
            <strong>{{ $question->answers_count }}</strong> {{ str_plural('answer', $question->answers_count) }}
        </div>

        <div class="views">
            {{ $question->views . ' ' . str_plural('view', $question->views) }}
        </div>
    </div>

    <div class="media-body">
        <div class="d-flex align-items-center">
            <h3 class="mt-0"><a href="{{ $question->url_getter }}">{{ $question->title }}</a></h3>

            <div class="ml-auto">
                {{--                                            <a class="btn btn-sm btn-outline-info" href="{{ route('questions.edit', $question->id) }}">Edit</a>--}}

                <form action="{{ route('questions.destroy', $question->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    @can('update', $question)
                        <a class="btn btn-sm btn-outline-info" href="{{ route('questions.edit', $question->id) }}">Edit</a>
                    @endcan

                    @can('delete', $question)
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure')">Delete</button>
                    @endcan
                </form>
            </div>
        </div>


        <p class="lead">
            Asked by
            <a href="{{ $question->user->url_getter }}">{{ $question->user->name }}</a>
            <small class="text-muted">{{ $question->created_date_getter }}</small>
        </p>

        <div class="excerpt">
            {{ $question->excerpt_body_html_getter }}
        </div>
    </div>
</div>
