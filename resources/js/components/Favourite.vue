<template>
    <a
        :class="classes"
        title="Click to mark as favourite question (Click again to undo)"
        @click.prevent="onToggle"
        :disabled="fetching">

        <i class="fas fa-star fa-3x"></i>
        <span class="favourites-count">{{ favouritesCount }}</span>
    </a>
</template>

<script>
    export default {
        name: "Favourite",
        props: ['question'],

        data() {
            return {
                isFavourite: this.question.is_favourite_getter,
                favouritesCount: this.question.favourites_count_getter,
                id: this.question.id,
                fetching: false
            }
        },

        computed: {
            classes() {
                return [
                    'favourite', 'mt-2',
                    ! this.signedIn ? 'off' : (this.isFavourite ? 'favourited' : '')
                ]
            },

            endpoint() {
                return `/questions/${this.id}/favourites`
            },

            signedIn() {
                return window.Auth.signedIn;
            }
        },

        methods: {
            onToggle() {
                if (this.fetching)
                    return;

                if (! this.signedIn) {
                    this.$toast.warning('Please login to favourite this question', 'Warning', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });

                    return;
                }

                this.isFavourite ? this.unFavourite() : this.favourite();
            },

            favourite() {
                this.fetching = true;

                axios.post(this.endpoint)
                    .then( (response) => {
                        this.favouritesCount++;
                        this.isFavourite = true;
                    })

                    .finally( () => this.fetching = false);
            },

            unFavourite() {
                this.fetching = true;

                axios.delete(this.endpoint)
                    .then( (response) => {
                        this.favouritesCount--;
                        this.isFavourite = false;
                    })

                    .finally( () => this.fetching = false);
            }
        }
    }
</script>

<style scoped>

</style>
