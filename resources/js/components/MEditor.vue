<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" :href="tabId('write', '#')">Write</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" :href="tabId('preview', '#')">Preview</a>
                </li>
            </ul>
        </div>

        <div class="card-body tab-content">
            <div class="tab-pane active" :id="tabId('write')">
                <slot></slot>
            </div>

            <div class="tab-pane" v-html="preview" :id="tabId('preview')">

            </div>

        </div>
    </div>
</template>

<script>
    import MarkdownIt from 'markdown-it';
    import prism from 'markdown-it-prism';

    import autosize from 'autosize';

    const markdownIt = new MarkdownIt();
    markdownIt.use(prism);

    export default {
        name: "MEditor",
        props: ['body', 'name'],

        computed: {
            preview() {
                return markdownIt.render(this.body);
            }
        },

        methods: {
            tabId(tabName, hash = '') {
                return `${hash}${tabName}${this.name}`;
            }
        },

        // watch: {
        //     body: function () {
        //         console.log('watch body');
        //     }
        // },

        updated() {
            autosize(this.$el.querySelector('textarea'));
        },

        // mounted() {
        //     autosize(this.$el.querySelector('textarea'));
        // }
    }
</script>

<style scoped>

</style>
