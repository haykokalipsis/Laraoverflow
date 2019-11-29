<script>
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
                                    $(this.$el).fadeOut(500, () => {
                                        this.$toast.success(response.data.message, 'Success', {timeout: 3000});
                                    });
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
        }
    }
</script>

<style scoped>

</style>
