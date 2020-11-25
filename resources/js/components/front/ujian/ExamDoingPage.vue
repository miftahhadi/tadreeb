<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills card-header-pills px-2">
                        <li class="nav-item">
                          <h3 class="card-title">Soal ke-{{ questionNumber }} dari {{ exam.questions_count}}</h3>
                        </li>

                        <li class="nav-item ml-auto">
                            <span class="bg-primary text-white rounded-lg py-2 px-2">
                                <timer
                                    :time-expires="timeExpires"
                                    @near:end="setNearEnd"
                                    @finished="timesUp"
                                ></timer>
                            </span>
                        </li>
                    </ul>
                </div>  

                <div v-for="question in questions" :key="question.id">

                    <div class="card-body" v-html="question.konten" v-show="question.id == questionId"></div>

                    <div class="card-body" v-show="question.id == questionId">

                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                            <label class="form-selectgroup-item flex-fill" v-for="answer in question.answers" :key="answer.id">
                                
                                <input :type="question.input" 
                                    class="form-selectgroup-input"
                                    :name="'answer[' + question.id + ']'"
                                    :value="answer.id"
                                    v-model="userAnswers[question.id]"
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
                                :class="isPrevDisabled"
                                @click="getQuestion(prevQuestion)"
                        >
                            <i class="fas fa-chevron-circle-left"></i>
                            <span class="ml-1">Sebelumnya</span>
                        </button>

                        <button class="btn btn-success"
                                :class="[chosen, savingAnswer]"
                                @click="updateAnswer(questionId)"
                        >Jawab</button>
                        
                        <button class="btn btn-white" 
                                :class="isNextDisabled"
                                @click="getQuestion(nextQuestion)"
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

            <button type="button" 
                    class="btn btn-success btn-block" 
                    data-toggle="modal" 
                    data-target="#submitModal"  
            >
                Selesai
            </button>

        </div>

        <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="dimmer" :class="isSubmitting">
                
                        <div class="loader"></div>
                        
                        <div class="dimmer-content">
                            
                            <template v-if="submitted">
                                <div class="modal-body text-center">
                                    <span class="avatar avatar-xl bg-success text-white"><i class="fas fa-check"></i></span>

                                    <h2 class="mt-4">Selamat! Anda selesai mengerjakan ujian</h2>

                                    <div>Jawaban Anda sudah tersimpan di database</div>

                                </div>
                                <div class="modal-footer">
                                    <a :href="kelasUrl" class="btn btn-success mr-auto">Kembali ke Beranda Kelas</a>
                                    <a :href="hasilUrl" class="btn btn-white">Lihat Jawaban</a>
                                </div>
                            </template>

                            <template v-else>
                                <div class="modal-body">

                                    <div class="modal-title">Apakah Anda yakin?</div>
                                    <div>Setelah mengirim jawaban, Anda tidak bisa kembali lagi untuk mengubah jawaban Anda.</div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Batal</button>
                                    <button type="button" 
                                            class="btn btn-success" 
                                            @click="submit"
                                    >Ya, saya sudah selesai</button>
                                </div>
                            </template>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'exam-doing-page',

    props: {
        examId: Number,
        classexamuserId: Number,
        attempt: Number,
        kelas: String,
        timeExpires: Number,
    },

    data() {
        return {
            exam: {},
            questionIds: [],
            questionId: 0,
            nextQuestion: 0,
            prevQuestion: 0,
            question: {},
            loading: false,
            answering: false,
            questions: {},
            userAnswers: {},
            submitting: false,
            submitted: false,
            kelasUrl: '/k/' + this.kelas + '/depan',
            nearEnd: false,
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

            this.getNextQuestionId()
            this.getPrevQuestionId()

        },

        getUserAnswers() {
            axios.get('/api/jawaban-user/' + this.classexamuserId)
                    .then(response => {
                        const answers = response.data

                        const questions = Object.keys(answers)

                        questions.forEach(question => {
                            this.$set(this.userAnswers, question, answers[question].answers)
                            // this.userAnswers[question] = userAnswers[question].answers
                        })

                    })
            
        },

        isCurrent(id) {
            return (this.questionId == id);
        },

        getNextQuestionId() {
            let lastIndex = this.exam.questions_count - 1

            if (this.questionIds.indexOf(this.questionId) != lastIndex) {
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

        updateAnswer(id) {
            this.answering = true; 

            let answer = this.userAnswers[id];

            // Update ke database
            this.saveAnswer(id, answer);

            if (this.nextQuestion != 0) {
                this.getQuestion(this.nextQuestion)                    
            }

        },

        saveAnswer(questionId, answer) {
            axios.post('/api/update-jawaban', {
                classexamuserId: this.classexamuserId,
                answerIds: answer,
                questionId: questionId
            }).then(response => {
                this.answering = false
            }).catch(error => {
                console.log(error)
            })
        },

        isAnswered(id) {
            return this.userAnswers[id].length != 0
        },

        submit() {
            this.submitting = true;

            // Simpan semua jawaban
            this.questionIds.forEach(id => {
                let answer = this.userAnswers[id];

                this.saveAnswer(id, answer);
            })

            // Rekam data selesai
            axios.post('/api/submit-ujian', {
                classexamuserId: this.classexamuserId
            }).then(response => {
                this.submitting = false;
                this.submitted = true;
            }).catch(error => {
                console.log(error)
            })
        },

        isTimed() {
            return (this.timeExpires != 0);
        },

        setNearEnd() {
            this.nearEnd = true;
        },

        timesUp() {
            
        }

    },

    created() {
        this.getExamInfo();
        console.log(this.now());
    },

    computed: {
        questionNumber() {
            return this.questionIds.indexOf(this.questionId) + 1
        },

        isPrevDisabled() {
            return (this.prevQuestion == 0) ? 'disabled' : '';
        },

        isNextDisabled() {
            return (this.nextQuestion == 0) ? 'disabled' : '';
        },

        chosen() {
            return (this.userAnswers[this.questionId] == '') ? 'disabled' : '';
        },

        savingAnswer() {
            return (this.answering) ? 'btn-loading' : '';
        },

        isSubmitting() {
            return (this.submitting) ? 'active' : '';
        },

        hasilUrl() {
            const currentUrl = window.location.pathname;

            return currentUrl.replace('/kerjakan', '/hasil/' + this.attempt);
        }

    },

}
</script>