<template>
    <div>
        <!-- Vote Up -->
        <a
            :title="`This  ${name} is useful`"
            @click.prevent="voteUp"
            :class="['vote-up', {'off' : authorize('vote', model) }]">

            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{ count }}</span>
        <!-- Vote Up END -->

        <!-- Vote Down -->
        <a
            :title="`This  ${name} is not useful`"
            @click.prevent="voteDown"
            :class="['vote-down', { 'off' : authorize('vote', model) }]">

            <i class="fas fa-caret-down fa-3x"></i>
        </a>
        <!-- Vote Down END-->
    </div>
</template>

<script>
    export default {
        name: "Vote",
        props: ['name', 'model', 'firstURISegment'],

        data() {
            return {
                count: this.model.votes_count,
            }
        },

        computed: {
            endpoint() {
                return `/${this.name}s/${this.model.id}/vote`;
            },
        },

        methods: {
            voteUp() {
                this._vote(1)
            },

            voteDown() {
                this._vote(-1);
            },

            _vote(vote) {
                if ( ! this.signedIn) {
                    this.$toast.warning(`Please login to vote the ${name}`, 'Warning', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });

                    return;
                }

                axios.post(this.endpoint, {
                    vote: vote
                })
                    .then( (response) => {
                        this.$toast.success(response.data.message, 'Success', {
                            timeout: 3000,
                            position: 'bottomLeft'
                        });

                        this.count = response.data.votes_count;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
