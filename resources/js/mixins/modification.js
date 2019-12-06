export default {
    data() {
        return {
            editing: false,
        }
    },

    methods: {
        onEdit() {
            this.beforeEditCache = {
                body: this.body,
                title: this.title
            };

            this.editing = true;
        },

        cancel() {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
            const el = this.$refs.bodyHtml;
            if (el)
                Prism.highlightAllUnder(el);
            this.editing = false;
        },
    }
}
