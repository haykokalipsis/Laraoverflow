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

