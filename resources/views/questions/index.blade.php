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
                            @include('questions._question')
                        @empty
                            <div class="alert alert-warning">
                                <strong>Sorry</strong> There are no questions available.
                            </div>
                        @endforelse

{{--                            <div class="d-flex">--}}
{{--                                <div class="mx-auto">--}}
{{--                                    {{ $questions->links() }}--}}
{{--                                </div>--}}
{{--                            </div>--}}

                        <div class="d-flex justify-content-center mt-3">
                            {{ $questions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
