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
                    })
                    .catch( (error) => {
                        console.error('Something went wrong');
                    })
            },

            onDestroy() {
                if (confirm('Sure about that?')) {
                    axios.delete(this.endpoint)
                        .then( (response) => {
                            $(this.$el).fadeOut(500, () => {
                                alert(response.data.message)
                            });
                        });
                }
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
