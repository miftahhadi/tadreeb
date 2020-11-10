<template>
    <div class="row">
        <div class="col-md-8">
            <exam-question-container
                :question-number="questionNumber"
                :questions-count="  exam.questions_count"
                :question-id="questionId"
                :question="question"
                :answers="answers"
                :type="getType()"
                :loading="loading"
                :next-question="nextQuestion"
                :prev-question="prevQuestion"
                :user-answers="userAnswers[questionId]"
                :answering="answering"
                @get:next="getQuestion(nextQuestion)"
                @get:prev="getQuestion(prevQuestion)"
                @update:answer="updateAnswer"
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
                            :answered="isAnswered(id)"
                            @show:question="getQuestion"
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
        examId: Number,
        classexamuserId: Number,
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
            userAnswers: {},
            answering: false,

            data: {},
            questions: {}
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

                        this.data = response.data
                        this.questions = response.data.questions
                        
                        this.getQuestion()

                        this.loading = false;
                    })
                    .catch(error => {
                        console.log(error)
                    });

            this.getUserAnswers()
        },

        getQuestion(id = this.questionId) {
            this.questionId = id 
            this.question = this.data.questions[id]

            this.getAnswers()
            this.getNextQuestionId()
            this.getPrevQuestionId()
        },

        getAnswers() {
            this.answers = this.questions[this.questionId].answers
        },

        getUserAnswers() {
            axios.get('/api/jawaban-user/' + this.classexamuserId)
                    .then(response => {
                        const userAnswers = response.data

                        const questions = Object.keys(userAnswers)

                        questions.forEach(question => {
                            this.userAnswers[question] = userAnswers[question].answers
                        })

                    })
            
        },

        isCurrent(id) {
            return (this.questionId == id);
        },

        getNextQuestionId() {
            let lastIndex = this.exam.questions_count

            if (this.questionId != lastIndex) {
                let index = this.questionIds.indexOf(this.questionId) + 1
               this.nextQuestion = this.questionIds[index];                
            } else {
                this.nextQuestion = 0
            }

        },

        getPrevQuestionId() {
            if (this.questionIds.indexOf(this.questionId) != 0) {
                let index = this.questionIds.indexOf(this.questionId) - 1
                this.prevQuestion = this.questionIds[index]
            } else {
                this.prevQuestion = 0
            }
        },

        updateAnswer(data) {
            this.answering = true; 

            let answer;

            if (Array.isArray(data)) {
                answer = data
            } else {
                answer = [data]
            }
            
            // Update ke database
            axios.post('/api/update-jawaban', {
                classexamuserId: this.classexamuserId,
                answerIds: answer,
                questionId: this.questionId
            }).then(response => {
                // Update jawaban peserta
                this.userAnswers[questionId] = [answer]
                
                this.answering = false
                this.getQuestion(this.nextQuestion)
            }).catch(error => {
                console.log(error)
            })

        },

        getType() {
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
        },

        isAnswered(id) {
            return this.userAnswers[id].length != 0
        }

    },

    mounted() {
        this.getExamInfo();
    },

    computed: {
        questionNumber() {
            return this.questionIds.indexOf(this.questionId) + 1
        },
    },


}
</script>