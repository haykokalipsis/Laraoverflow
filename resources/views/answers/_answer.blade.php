<answer-component :answer="{{ $answer }}" inline-template>
    <div class="media post">

        <controls-component :model="{{ $answer }}" name="answer"></controls-component>

        <div class="media-body">
            <form @submit.prevent="onUpdate" v-if="editing">
                <div class="form-group">
                    <textarea rows="10" class="form-control" v-model="body"></textarea>
                </div>

                <button type="button" @click="cancel()">Cancel</button>
{{--                <button type="submit" @click="editing = false">Update</button>--}}
                <input type="submit" value="Update Input" :disabled="isInvalid">
            </form>

            <template v-else>
                <div v-html="bodyHtml"></div>
{{--                {!! $answer->excerpt_getter !!}--}}

                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can('update', $answer)
                                <a @click.prevent="edit()" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan

                            @can('delete', $answer)
                                <button type="submit" class="btn btn-sm btn-outline-danger" @click.prevent="onDestroy">Delete</button>
                            @endcan
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
            </template>
        </div>
    </div>
</answer-component>
