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
                            @include('partials.controls._controls', [
                                'model' => $question
                            ])

                            <!-- Question Body -->
                            <div class="media-body">
                                {!! $question->body_html_getter !!}

                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">

{{--                                        @include('partials._author', [--}}
{{--                                            'model' => $question,--}}
{{--                                            'label' => 'asked'--}}
{{--                                        ])--}}

                                        <!-- user-info component -->
                                        <user-info-component
                                            :model="{{ $question }}"
                                            label="asked">

                                        </user-info-component>
                                        <!-- user-info component END-->
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
