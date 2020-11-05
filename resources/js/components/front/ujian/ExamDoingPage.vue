<template>
    <div class="row">
        <div class="col-md-8">
            <exam-question-container
                :question-number="questionNumber"
                :questions-count="exam.questions_count"
                :question="question"
                :answers="answers"
                :type="type"
                :loading="loading"
                :next-question="nextQuestion"
                :prev-question="prevQuestion"
                @get:next="newQuestion(nextQuestion)"
                @get:prev="newQuestion(prevQuestion)"
            ></exam-question-container>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Direktori Soal</h3>
                </div>

                <div class="card-body">
                    <div class="btn-list justify-content-center">

                        <exam-number-button
                            v-for="(id, index) in questionIds" :key="index"
                            :btn-number="++index"
                            :id="id"
                            :current="isCurrent(id)"
                            @show:question="newQuestion"
                        ></exam-number-button>

                    </div>
                </div>

            </div>

            <a href="#" class="btn btn-success btn-block"><span class="font-weight-bolder">Selesai</span></a>

        </div>
    </div>
</template>

<script>
export default {
    name: 'exam-doing-page',

    props: {
        examId: Number
    },

    data() {
        return {
            exam: {},
            questionIds: [],
            questionId: 0,
            nextQuestion: 0,
            prevQuestion: 0,
            question: {},
            answers: [],
            loading: false,
        }
    },

    methods: {
        getExamInfo() {
            this.loading = true;

            axios.get('/api/ujian/' + this.examId)
                    .then(response => {
                        this.exam = response.data.exam
                        this.questionIds = response.data.questionIds
                        this.questionId = response.data.questionIds[0]

                        this.getQuestion()

                        this.loading = false;
                    })
                    .catch(error => {
                        console.log(error)
                    });
        },

        getQuestion() {
            this.loading = true;

            axios.get('/api/soal/' + this.questionId)
                    .then(response => {
                        this.question = response.data.soal
                        this.answers = response.data.answers

                        this.getNextQuestionId()
                        this.getPrevQuestionId()

                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error);
                    });
        },

        newQuestion(id) {
            this.questionId = id;
            this.getQuestion()
        },

        isCurrent(id) {
            return (this.questionId == id);
        },

        getNextQuestionId() {
            let lastIndex = this.questionIds.length - 1

            if (this.questionIds.indexOf(this.questionId) != lastIndex) {
                let index = this.questionIds.indexOf(this.questionId) + 1;
                this.nextQuestion = this.questionIds[index]                
            } else {
                this.nextQuestion = 0
            }

        },

        getPrevQuestionId() {
            if (this.questionIds.indexOf(this.questionId) != 0) {
                let index = this.questionIds.indexOf(this.questionId) - 1
                this.prevQuestion = this.questionIds[index]
            }
        },

    },

    mounted() {
        this.getExamInfo();
    },

    computed: {
        questionNumber() {
            return this.questionIds.indexOf(this.questionId) + 1
        },

        type() {
            let input;

            switch (this.question.tipe) {
                case 'Pilihan Ganda':
                    input = 'radio'         
                    break;
                
                case 'Jawaban Ganda':
                    input = 'checkbox'
                    break;
                
                case 'Benar/Salah':
                    input = 'radio'
                    break;

                default:
                    input = 'radio'
                    break;
            }

            return input;
        }
    },


}
</script>