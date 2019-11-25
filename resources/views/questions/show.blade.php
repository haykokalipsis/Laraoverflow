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
                                <a title="This question is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>

                                <span class="votes-count">1230</span>
                                <a title="This question is not useful" class="vote-down off">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>

                                <a title="Click to mark as favourite question (Click again to undo)" class="favourite mt-2 favourited">
                                    {{--                                Favourite--}}
                                    <i class="fas fa-star fa-3x"></i>
                                    <span class="favourites-count">{{ $question->favourites_count_getter }}</span>
                                </a>
                            </div>

                            <div class="media-body">

                                {!! $question->body_html_getter !!}

                                <div class="float-right">
                                    <span class="text-muted">Answered {{ $question->created_date_getter }}</span>

                                    <div class="media mt-2">
                                        <a href="{{ $question->user->url_getter }}" class="pr-2">
                                            <img src="{{ $question->user->avatar_getter }}" alt="">
                                        </a>

                                        <div class="media-body mt-1">
                                            <a href="{{ $question->user->url_getter }}">{{ $question->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
