<template>
    <div>
        <span class="text-muted">{{ postDate }}</span>

        <div class="media mt-2">
            <a :href="user.url_getter" class="pr-2">
                <img :src="user.avatar_getter" alt="">
            </a>

            <div class="media-body mt-1">
                <a :href="user.url_getter">{{ user.name }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserInfo",
        props: ['model', 'label'],

        data() {
            return {
                user: this.model.user
            }
        },

        computed: {
            postDate() {
                return this.label + ' ' + this.model.created_date_getter;
            }
        },
    }
</script>

<style scoped>

</style>
