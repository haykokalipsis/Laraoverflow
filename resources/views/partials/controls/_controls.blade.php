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
    <vote-component
        name="{{ $name }}"
        :model="{{ $model }}"
        firstURISegment="{{ $firstURISegment }}">
    </vote-component>
    <!-- Vote END -->

    <!-- Favourite the question or accept best answer-->
    @if ($model instanceof App\Question)
        <favourite-component :question="{{ $model }}"></favourite-component>
    @elseif ($model instanceof App\Answer)
        <accept-component :answer="{{ $answer }}"></accept-component>
    @endif
    <!-- Favourite the question or accept best answer END-->
</div>
