<!-- Vote Up -->
<a
    title="This {{ $name }} is useful"
    class="vote-up {{ Auth::guest() ? 'off' : '' }}"
    onclick="event.preventDefault(); document.getElementById('up-vote-{{ $name }}-{{ $model->id }}').submit();">

    <i class="fas fa-caret-up fa-3x"></i>
</a>

<form action="/{{ $firstURISegment }}/{{$model->id}}/vote" id="up-vote-{{ $name }}-{{ $model->id }}" method="post" style="display: none;">
    @csrf
    <input type="hidden" name="vote" value="1">
</form>

<span class="votes-count">{{ $model->votes_count }}</span>
<!-- Vote Up END -->

<!-- Vote Down -->
<a
    title="This {{ $name }} is not useful"
    class="vote-down {{ Auth::guest() ? 'off' : '' }}"
    onclick="event.preventDefault(); document.getElementById('down-vote-{{ $name }}-{{ $model->id }}').submit();">

    <i class="fas fa-caret-down fa-3x"></i>
</a>

<form action="/{{ $firstURISegment }}/{{$model->id}}/vote" id="down-vote-{{ $name }}-{{ $model->id }}" method="post" style="display: none;">
    @csrf
    <input type="hidden" name="vote" value="-1">
</form>
<!-- Vote Down END-->
