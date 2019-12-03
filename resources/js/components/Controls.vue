<template>
    <div class="d-flex flex-column vote-controls">
        <!-- Vote  -->
        <vote-component
            :name="name"
            :model="model"
            :firstURISegment="firstURISegment">
        </vote-component>
        <!-- Vote END -->

        <!-- Favourite the question or accept best answer-->
        <favourite-component v-if="name === 'question'" :question="model"></favourite-component>

        <accept-component v-if="name === 'answer'" :answer="model"></accept-component>
        <!-- Favourite the question or accept best answer END-->
    </div>
</template>

<script>
    // import favourite'./fav'

    export default {
        name: "Controls",
        props: ['model', 'name'],

        data() {
            return {
                // firstURISegment: null
            }
        },

        computed: {
            firstURISegment() {
                if (this.name === 'question') return 'questions';
                if (this.name === 'answer') return 'answers';
            }
        },
    }
</script>

<style scoped>

</style>
