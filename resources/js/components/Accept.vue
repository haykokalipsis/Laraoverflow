<template>
    <div>
        <a
            v-if="authorize('accept', answer)"
            title="Mark this answer as best answer"
            :class="classes"
            @click.prevent="onAccept">

            <i class="fas fa-check fa-3x"></i>
        </a>

        <a
            v-if="isAccepted"
            title="Best answer"
            :class="classes">

            <i class="fas fa-check fa-3x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        name: "Accept",
        props: ['answer'],

        data() {
            return {
                isBest: this.answer.is_best_getter,
                id: this.answer.id
            }
        },

        computed: {
            canAccept() {
                return true;
            },

            isAccepted() {
                return ! this.canAccept && this.isBest;
            },

            classes() {
                return [
                    'mt-2',
                    this.isBest ? 'vote-accepted' : ''
                ];
            }
        },

        methods: {
            onAccept() {
                axios.post(`/answers/${this.id}/accept`)
                    .then( (response) => {
                        this.$toast.success(response.data.message, 'Success', {
                            timeout: 3000,
                            position: 'bottomLeft'
                        });

                        this.isBest = true;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
