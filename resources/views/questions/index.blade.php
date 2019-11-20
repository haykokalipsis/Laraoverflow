@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">All Questions</div>

                    <div class="card-body">
                        @forelse($questions as $question)
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="mt-0">{{ $question->title }}</h3>
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
