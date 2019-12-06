<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form @submit.prevent="onUpdate" class="card-body" v-show="authorize('modify', question) && editing">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" v-model="title">
                    </div>

                    <hr>

                    <div class="media">
                        <!-- Question Body -->
                        <div class="media-body">
                            <div class="form-group">
                                <!-- MEditor -->
                                <m-editor :body="body" :name="uniqueName">
                                    <textarea rows="10" class="form-control" v-model="body"></textarea>
                                </m-editor>
                                <!-- MEditor END-->
                            </div>

                            <button type="button" @click.prevent="onCancel">Cancel</button>
                            <input type="submit" value="Update Input" :disabled="isInvalid">
                        </div>
                        <!-- Question Body END -->

                    </div>
                </form>

                <div class="card-body" v-show="!editing">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ title }}</h1>

                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-secondary">Back to all questions</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="media">

                        <controls-component :model="question" name="question"></controls-component>

                        <!-- Question Body -->
                        <div class="media-body">
                            <div v-html="bodyHtml" ref="bodyHtml"></div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        <button v-if="authorize('modify', question)" @click.prevent="onEdit" class="btn btn-sm btn-outline-info">Edit</button>
                                        <button v-if="authorize('deleteQuestion', question)" @click.prevent="onDestroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">

                                    <!-- user-info component -->
                                    <user-info-component
                                        :model="question"
                                        label="asked">

                                    </user-info-component>
                                    <!-- user-info component END-->
                                </div>
                            </div>
                        </div>
                        <!-- Question Body END -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ControlsComponent from "../components/Controls";
    import UserInfoComponent from "../components/UserInfo";
    import MEditor from "./MEditor";
    import Prism from 'prismjs';

    export default {
        name: "Question",
        props: ['question'],

        data() {
            return {
                editing: false,
                title: this.question.title,
                body: this.question.body,
                bodyHtml: this.question.full_body_html_getter,
                id: this.question.id,
                beforeEditCache: {}
            }
        },

        computed: {
            isInvalid() {
                return this.body.length < 10 || this.title.length < 10;
            },

            endpoint() {
                return `/questions/${this.id}`;
            },

            uniqueName() {
                return `answer-${this.id}`;
            }
        },

        methods: {
            setEditCache() {
                this.beforeEditCache = {
                    title: this.title,
                    body: this.body
                };
            },

            restoreFromEditCache() {
                this.body = this.beforeEditCache.body;
                this.title = this.beforeEditCache.title;
            },

            highlight(id = '') {
                let el;

                if ( ! id)
                    el = this.$refs.bodyHtml;
                else
                    el = document.getElementById(id);

                console.log(el);
                Prism.highlightAllUnder(el);
            },

            onEdit() {
                this.setEditCache();
                this.editing = true;
            },

            onCancel() {
                this.restoreFromEditCache();
                this.editing = false;
            },

            onUpdate() {

                axios.put(this.endpoint, {
                    body: this.body,
                    title: this.title
                })
                    .then( ({data}) => {
                        this.bodyHtml = data.bodyHtml;
                        this.question.title = data.title;

                        this.$toast.success(data.message, 'Success', {timeout: 3000});
                        this.editing = false;
                    })
                    .then ( () => this.highlight())
                    .catch( ({response}) => {
                        this.$toast.error(response.data.message, 'Error', {timeout: 3000});
                        this.editing = false;
                    });
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
                                    this.$toast.success(response.data.message, 'Success', {timeout: 2000});
                                    this.$emit('deleted');
                                });

                            setTimeout( () => {
                                window.location.href = '/questions';
                            },3000);

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],

                });
            },
        },

        components: {
            ControlsComponent,
            UserInfoComponent,
            MEditor
        }
    }
</script>

<style scoped>

</style>
