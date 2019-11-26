@if ($model instanceof App\Question)
    @php
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp
@elseif ($model instanceof App\Answer)
    @php
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif

<div class="d-flex flex-column vote-controls">
    <!-- Vote  -->
    @include('partials.controls._vote', [
        'name' => $name,
        'model' => $model,
        'firstURISegment' => $firstURISegment,
    ])
    <!-- Vote END -->

    <!-- Favourite the question or accept best answer-->
    @if ($model instanceof App\Question)
        @include('partials.controls._favourite', [
            'question' => $model
        ])
    @elseif ($model instanceof App\Answer)
        @include('partials.controls._accept', [
            'answer' => $model
        ])
    @endif
    <!-- Favourite the question or accept best answer END-->
</div>
