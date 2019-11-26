@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{ $question->title }}</h1>

                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all questions</a>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <!-- Vote Up -->
                                <a
                                    title="This question is useful"
                                    class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                    onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit();">

                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>

                                <form action="/questions/{{$question->id}}/vote" id="up-vote-question-{{ $question->id }}" method="post" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>

                                <span class="votes-count">{{ $question->votes_count }}</span>
                                <!-- Vote Up END -->

                                <!-- Vote Down -->
                                <a
                                    title="This question is not useful"
                                    class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                                    onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit();">

                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>

                                <form action="/questions/{{$question->id}}/vote" id="down-vote-question-{{ $question->id }}" method="post" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>
                                <!-- Vote Down END-->

                                <!-- Favourite the question -->
                                <a
                                    title="Click to mark as favourite question (Click again to undo)"
                                    class="favourite mt-2 {{ Auth::guest() ? 'off' : ($question->is_favourite_getter) ? 'favourited' : ''}}"
                                    onclick="event.preventDefault(); document.getElementById('favourite-question-{{ $question->id }}').submit();">

                                    <i class="fas fa-star fa-3x"></i>
                                    <span class="favourites-count">{{ $question->favourites_count_getter }}</span>
                                </a>

                                <form action="/questions/{{$question->id}}/favourites" id="favourite-question-{{ $question->id }}" method="post" style="display: none;">
                                    @csrf
                                    @if ($question->is_favourite_getter)
                                        @method('DELETE')
                                    @endif
                                </form>
                                <!-- Favourite the question END-->
                            </div>

                            <!-- Question Body -->
                            <div class="media-body">
                                {!! $question->body_html_getter !!}

                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        @include('partials._author', [
                                            'model' => $question,
                                            'label' => 'asked'
                                        ])

                                    </div>
                                </div>
                            </div>
                            <!-- Question Body END -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('answers._index', [
            'answers' => $question->answers,
            'answers_count' => $question->answers_count
        ])

        @auth()
            @include('answers._create')
        @endauth
    </div>
@endsection
