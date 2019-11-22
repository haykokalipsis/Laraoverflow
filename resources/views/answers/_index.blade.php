<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answers_count . ' ' . str_plural('Answer', $answers_count) }}</h2>
                </div>

                <hr>

                @include('partials._flash-messages')

                @foreach($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="This answer is useful" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>

                            <span class="votes-count">1230</span>
                            <a title="This answer is not useful" class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>

                            @can('accept', $answer)
                                <a
                                    title="Mark this answer as best answer"
                                    class="mt-2 {{ $answer->status_getter }}"
                                    onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();">

                                    <i class="fas fa-check fa-3x"></i>
                                </a>

                                <form action="{{ route('answers.accept', $answer->id) }}" id="accept-answer-{{ $answer->id }}" method="post" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                @if ($answer->is_best_getter)
                                    <a
                                        title="Best answer"
                                        class="mt-2 {{ $answer->status_getter }}">

                                        <i class="fas fa-check fa-3x"></i>
                                    </a>
                                @endif
                            @endcan
                        </div>

                        <div class="media-body">
                            {!! $answer->body_html_getter !!}

                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            @can('update', $answer)
                                                <a class="btn btn-sm btn-outline-info" href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}">Edit</a>
                                            @endcan

                                            @can('delete', $answer)
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure')">Delete</button>
                                            @endcan
                                        </form>
                                    </div>
                                </div>

                                <div class="col-4">

                                </div>

                                <div class="col-4">
                                    <span class="text-muted">Answered {{ $answer->created_date_getter }}</span>

                                    <div class="media mt-2">
                                        <a href="{{ $answer->user->url_getter }}" class="pr-2">
                                            <img src="{{ $answer->user->avatar_getter }}" alt="">
                                        </a>

                                        <div class="media-body mt-1">
                                            <a href="{{ $answer->user->url_getter }}">{{ $answer->user->name }}</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
