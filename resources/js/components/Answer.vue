<template>
    <div class="media post">

        <controls-component :model="answer" name="answer"></controls-component>

        <div class="media-body">
            <form @submit.prevent="onUpdate" v-if="editing">
                <div class="form-group">
                    <textarea rows="10" class="form-control" v-model="body"></textarea>
                </div>

                <button type="button" @click="cancel()">Cancel</button>
                <input type="submit" value="Update Input" :disabled="isInvalid">
            </form>

            <template v-else>
                <div v-html="bodyHtml"></div>

                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <button v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</button>
                            <button v-if="authorize('modify', answer)" @click.prevent="onDestroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        </div>
                    </div>

                    <div class="col-4"></div>
                    <div class="col-4">
                        <!-- user-info component-->
                        <user-info-component
                            :model="answer"
                            label="answered">
                        </user-info-component>
                        <!-- user-info component END-->
                    </div>
                </div>
            </template>
        </div>
    </div>

</template>

<script>
    import ControlsComponent from '../components/Controls';
    import UserInfoComponent from '../components/UserInfo';

    export default {
        name: "Answer",
        props: ['answer'],

        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.full_body_html_getter,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null
            }
        },

        computed: {
            isInvalid() {
                return this.body.length < 10;
            },

            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        },

        methods: {
            onUpdate() {
                axios.put(`/questions/${this.questionId}/answers/${this.id}`, {
                    body: this.body
                })
                    .then( (response) => {
                        this.editing = false;
                        this.bodyHtml = response.data.bodyHtml;
                        this.$toast.success(response.data.message, 'Success', {timeout: 3000});
                    })
                    .catch( (error) => {
                        this.$toast.error(error.response.data.message, 'Error', {timeout: 3000});
                    })
            },

            onDestroy() {
                this.$toast.question('Are you sure about that?', 'Confirm',{
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {
                            axios.delete(this.endpoint)
                                .then( (response) => {
                                    this.$emit('deleted');
                                });

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],

                });
            },

            edit() {
                this.beforeEditCache = this.body;
                this.editing = true;
            },

            cancel() {
                this.body = this.beforeEditCache;
                this.editing = false;
            }
        },

        components: {
            ControlsComponent,
            UserInfoComponent
        }
    }
</script>

<style scoped>

</style>
