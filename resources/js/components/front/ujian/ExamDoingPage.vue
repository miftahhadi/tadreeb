<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Soal ke-{{ questionNumber }} dari {{ exam.questions_count}}</h3>
                </div>

                <div v-for="question in questions" :key="question.id">

                    <div class="card-body" v-html="question.konten" v-show="question.id == questionId"></div>

                    <div class="card-body" v-show="question.id == questionId">
                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">


                            <label class="form-selectgroup-item flex-fill" v-for="answer in question.answers" :key="answer.id">
                                
                                <input :type="getType(question.id)" 
                                    class="form-selectgroup-input"
                                    v-model="userAnswers[questionId]"
                                >

                                <div class="form-selectgroup-label d-flex align-items-center p-3">
                                    <div class="mr-3">
                                        <span class="form-selectgroup-check"></span>
                                    </div>
                                    <div v-html="answer.redaksi"></div>
                                </div>
                            </label>


                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="btn-list">
                        <button class="btn btn-white" 
                                v-if="prevQuestion != 0"
                        >
                            <i class="fas fa-chevron-circle-left"></i>
                            <span class="ml-1">Sebelumnya</span>
                        </button>

                        <button class="btn btn-success"
                        >Jawab</button>
                        
                        <button class="btn btn-white" 
                                v-if="nextQuestion != 0"
                        >
                            <span class="mr-1">Lewati</span>
                            <i class="fas fa-chevron-circle-right"></i>
                        </button>
                    </div>
                    
                </div>

            </div>
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
            answering: false,

            data: {},
            questions: {},
            userAnswers: {},
            soalKey: 0,
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

            this.getNextQuestionId()
            this.getPrevQuestionId()

            this.soalKey += 1
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

        isAnswered(id) {
            return this.userAnswers[id].length != 0
        },

        getType(questionId) {
            let input;

            switch (this.questions[questionId]) {
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

    mounted() {
        this.getExamInfo();
    },

    computed: {
        questionNumber() {
            return this.questionIds.indexOf(this.questionId) + 1
        },

        type() {
            
        },
    },


}
</script>