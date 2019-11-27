<div class="media post">
    @include('partials.controls._controls', [
        'model' => $answer
    ])

    <div class="media-body">
        {!! $answer->excerpt_getter !!}

        <div class="row">
            <div class="col-4">
                <div class="ml-auto">
                    <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                        @csrf
                        @method('DELETE')

                        @can('update', $answer)
                            <a class="btn btn-sm btn-outline-info" href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}">Edit</a>
                        @endcan

                        @can('delete', $answer)
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure')">Delete</button>
                        @endcan
                    </form>
                </div>
            </div>

            <div class="col-4"></div>
            <div class="col-4">
{{--                @include('partials._author', [--}}
{{--                    'model' => $answer,--}}
{{--                    'label' => 'answered',--}}
{{--                ])--}}

                <!-- user-info component-->
                <user-info-component
                    :model="{{ $answer }}"
                    label="answered">

                </user-info-component>
                <!-- user-info component END-->
            </div>
        </div>

    </div>
</div>
