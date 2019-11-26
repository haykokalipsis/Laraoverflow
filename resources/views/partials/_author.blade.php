<span class="text-muted">Answered {{ $label . ' ' .$model->created_date_getter }}</span>

<div class="media mt-2">
    <a href="{{ $model->user->url_getter }}" class="pr-2">
        <img src="{{ $model->user->avatar_getter }}" alt="">
    </a>

    <div class="media-body mt-1">
        <a href="{{ $model->user->url_getter }}">{{ $model->user->name }}</a>
    </div>
</div>
