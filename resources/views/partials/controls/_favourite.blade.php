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
