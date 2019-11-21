@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2> Questions</h2>

                            <div class="ml-auto">
                                <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                    @include('partials._flash-messages-new')

                    @forelse($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="votes">
                                        <strong>{{ $question->votes }}</strong> {{ str_plural('vote', $question->votes) }}
                                    </div>

                                    <div class="status {{ $question->status_attr }}">
                                        <strong>{{ $question->answers }}</strong> {{ str_plural('answer', $question->answers) }}
                                    </div>

                                    <div class="views">
                                        {{ $question->views . ' ' . str_plural('view', $question->views) }}
                                    </div>
                                </div>

                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{ $question->url_attr }}">{{ $question->title }}</a></h3>

                                        <div class="ml-auto">
                                            <a class="btn btn-sm btn-outline-info" href="{{ route('questions.edit', $question->id) }}">Edit</a>
                                        </div>
                                    </div>


                                    <p class="lead">
                                        Asked by
                                        <a href="{{ $question->user->urlAttr }}">{{ $question->user->name }}</a>
                                        <small class="text-muted">{{ $question->created_date_attr }}</small>
                                    </p>

                                    {{ str_limit($question->body, 250) }}
                                </div>
                            </div>
                            <hr>
                        @empty
                            <p>No questions</p>
                        @endforelse

{{--                            <div class="d-flex">--}}
{{--                                <div class="mx-auto">--}}
{{--                                    {{ $questions->links() }}--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="d-flex justify-content-center">
                                {{ $questions->links() }}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
