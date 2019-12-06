<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>

                    <form @submit.prevent="onCreate">
                        <div class="form-group">
                            <m-editor :body="body" name="new-answer">
                                <textarea name="body" id="" rows="7" required class="form-control" v-model="body"></textarea>
                            </m-editor>
                        </div>

                        <div class="form-group">
                            <button type="submit" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MEditor from "./MEditor";

    export default {
        name: "NewAnswer",
        props: ['questionId'],

        data() {
            return {
                body: ''
            }
        },

        computed: {
            isInvalid() {
                return ! window.Auth.signedIn || this.body.length < 10;
            }
        },

        methods: {
            onCreate() {
                axios.post(`/questions/${this.questionId}/answers`, {
                    body: this.body
                })
                    .then( ({data}) => {
                        this.$toast.success(data.message, 'Success');
                        this.body = '';
                        this.$emit('created', data.answer);
                    })
                    .catch( (error) => {
                        this.$toast.error(error.response.data.message, 'Error', {
                            timeout: 3000,
                            position: 'bottomLeft'
                        });
                    });
            }
        },

        components: {
            MEditor
        }
    }
</script>

<style scoped>

</style>
