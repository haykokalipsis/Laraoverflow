<template>
    <div class="container">
        <question-component :question="question"></question-component>
        <answers-component :question="question"></answers-component>
    </div>
</template>

<script>
    import QuestionComponent from '../components/Question';
    import AnswersComponent from '../components/Answers';

    export default {
        name: "QuestionPage",
        props: ['question'],

        components: {
            QuestionComponent,
            AnswersComponent
        }
    }
</script>

<style scoped>

</style>
