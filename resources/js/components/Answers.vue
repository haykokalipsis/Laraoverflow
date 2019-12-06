<template>

    <div>
        <div class="row mt-4" v-cloak v-if="count">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>{{ title }}</h2>
                        </div>

                        <hr>

                        <answer v-for="(answer, index) in answers" :key="answer.id"
                                :answer="answer" @deleted="remove(index)">
                        </answer>

                        <div class="text-center mt-3" v-if="nextUrl">
                            <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more
                                answers
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <new-answer @created="add" :question-id="question.id"></new-answer>
    </div>
</template>

<script>
    import Answer from './Answer';
    import NewAnswer from './NewAnswer';
    import Prism from 'prismjs';

    export default {
        name: "Answers",
        props: ['question'],

        data() {
            return {
                questionId: this.question.id,
                count: this.question.answers_count,
                answers: [],
                nextUrl: null,
                answerIds: [],
            }
        },

        computed: {
            title() {
                return this.count + ' ' + (this.count > 1 ? 'Answers' : 'Answer');
            }
        },

        components: {
            Answer,
            NewAnswer
        },

        created() {
            this.fetch(`/questions/${this.questionId}/answers`);
        },

        methods: {
            fetch(endpoint) {
                this.answerIds = [];

                axios.get(endpoint)
                    .then( ({data}) => {
                        this.answerIds = data.data.map( (a) => a.id);
                        this.answers.push(...data.data);
                        this.nextUrl = data.next_page_url;
                    })
                    .then( () => {
                        console.log(this.answerIds);
                        this.answerIds.forEach( (id) => {
                            this.highlight(`answer-${id}`);
                        });
                    });
            },

            remove(index) {
                this.answers.splice(index, 1);
                this.count--;
            },

            highlight(id = '') {
                let el;

                if ( ! id)
                    el = this.$refs.bodyHtml;
                else
                    el = document.getElementById(id);

                console.log(el);
                Prism.highlightAllUnder(el);
            },

            add(answer) {
                this.answers.push(answer);
                this.count++;
                this.$nextTick( () => {
                    this.highlight(`answer-${answer.id}`);
                });
            }
        }
    }
</script>

<style scoped>

</style>
