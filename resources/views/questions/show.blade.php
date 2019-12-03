@extends('layouts.app')

@section('content')
    <div class="container">
        <question-component :question="{{ $question }}"></question-component>
        <answers-component :question="{{ $question }}"></answers-component>
    </div>
@endsection
