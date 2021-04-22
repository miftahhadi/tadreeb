<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills card-header-pills px-2">
                        <li class="nav-item">
                          <h3 class="card-title">Soal ke-{{ questionNumber }} dari {{ examData.questions_count}}</h3>
                        </li>

                        <li class="nav-item ml-auto">
                            <timer
                                v-if="isTimed()"
                                :end="examExpires"
                                @finished="timesUp"
                            ></timer>
                        </li>
                    </ul>
                </div>  

                    <div class="card-body" v-html="question.konten"></div>

                    <div class="card-body">

                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                            <label class="form-selectgroup-item flex-fill" v-for="answer in question.answers" :key="answer.id">
                                
                                <input :type="question.input_type" 
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

                <div class="card-footer">
                    <div class="btn-list">
                        <button class="btn btn-white" 
                                :class="isPrevDisabled"
                                @click="getQuestion(prevQuestion)"
                        >
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>
                            </span>
                            <span class="ml-1">Sebelumnya</span>
                        </button>

                        <button class="btn btn-success"
                                :class="[chosen, savingAnswer]"
                                @click="updateAnswer(currentQuestionId)"
                        >
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 11 12 14 20 6" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                            </span>
                            Jawab
                        </button>
                        
                        <button class="btn btn-white" 
                                :class="isNextDisabled"
                                @click="getQuestion(nextQuestion)"
                        >
                            <span class="mr-1">Lewati</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>
                            </span>
                        </button>
                    </div>
                    
                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card row">
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
            
            <div class="d-flex justify-content-center">
                <button type="button" 
                        class="btn btn-success btn-block mt-2" 
                        data-toggle="modal" 
                        data-target="#submitModal"  
                >
                    Selesai
                </button>
            </div>

        </div>

        <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="dimmer" :class="isSubmitting">
                
                        <div class="loader"></div>
                        
                        <div class="dimmer-content">
                            
                            <template v-if="submitted">
                                <div class="modal-body text-center">
                                    <span class="avatar rounded-circle avatar-xl bg-success text-white"
                                            style="background-image: url('/static/check.svg')"        
                                    >
                                    </span>

                                    <h2 class="mt-4">Selamat! Anda selesai mengerjakan ujian</h2>

                                    <div>Jawaban Anda sudah tersimpan di database</div>

                                </div>
                                <div class="modal-footer">
                                    <a :href="kelasUrl" class="btn btn-success mr-auto">Kembali ke Beranda Kelas</a>
                                    <a :href="hasilUrl" class="btn btn-white">Lihat Jawaban</a>
                                </div>
                            </template>

                            <template v-else-if="expired">
                                <div class="modal-body text-center">
                                    <span class="avatar avatar-xl bg-danger text-white">
                                        <i class="fas fa-hourglass-end"></i>
                                    </span>

                                    <h2 class="mt-4">Waktu Habis!</h2>

                                    <div>Anda tidak diizinkan melanjutkan ujian</div>
                                </div>
                                <div class="modal-footer btn-list justify-content-center">
                                    <a :href="kelasUrl" class="btn btn-light">Ke Halaman Kelas</a>

                                    <button type="button" 
                                            class="btn btn-success" 
                                            @click="submit"
                                    >Kirim jawaban saya</button>
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
        kelas: String,
        examData: Object,
        questions: Array,
        examableuser: Object,
    },

    data() {
        return {
            question: {},
            questionIds: [],
            currentQuestionId: 0,
            
            nextQuestion: 0,
            prevQuestion: 0,
            loading: false,
            answering: false,

            userAnswers: {},

            submitting: false,
            submitted: false,
            
            kelasUrl: '/k/' + this.kelas + '/depan',

            examExpires: null,
            expired: false,
        }
    },

    methods: {
        getQuestion(id) {
            this.currentQuestionId = id 
            this.question = this.questions[this.questionIds.indexOf(this.currentQuestionId)]

            this.getNextQuestionId()
            this.getPrevQuestionId()

            if (this.question.input_type == 'checkbox' && !Array.isArray(this.userAnswers[id])) {
                this.userAnswers[id] = (this.userAnswers[id] == '') ? [] : [this.userAnswers[id]] 
            }
        },

        getExamInfo() {
            this.questionIds = this.questions.map((question) => { return question.id})
            this.examExpires = this.examData.expires

            this.getQuestion(this.questionIds[0])
        },

        isCurrent(id) {
            return (this.currentQuestionId == id);
        },

        getNextQuestionId() {
            const lastIndex = this.examData.questions_count - 1
            const currentIndex = this.questionIds.indexOf(this.currentQuestionId)

            if (currentIndex != lastIndex) {
                let index = currentIndex + 1
               this.nextQuestion = this.questionIds[index];                
            } else {
                this.nextQuestion = 0
            }

        },

        getPrevQuestionId() {
            const currentIndex = this.questionIds.indexOf(this.currentQuestionId)

            if (currentIndex != 0) {
                let index = currentIndex - 1
                this.prevQuestion = this.questionIds[index]
            } else {
                this.prevQuestion = 0
            }
        },

        updateAnswer(id) {
            this.answering = true; 

            let answer = this.userAnswers[id];

            // Update ke database
            this.saveAnswer(answer);

        },

        saveAnswer(answer) {
            axios.put('/api/ujian/' + this.examData.id + '/update-jawaban', {
                examableUserId: this.examableuser.id,
                answerIds: answer,
                questionId: this.currentQuestionId
            }).then(response => {
                console.log(response.data)

                if (this.nextQuestion != 0) {
                    this.getQuestion(this.nextQuestion)                    
                }
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

            // Rekam data selesai dan kirim jawaban
            axios.post('/api/ujian/' + this.examData.id + '/submit-ujian', {
                examableUserId: this.examableuser.id,
                userAnswers: this.userAnswers
            }).then(response => {
                this.submitting = false;
                this.submitted = true;
            }).catch(error => {
                console.log(error)
            })
        },

        isTimed() {
            return (this.examExpires != 0);
        },

        timesUp() {
            this.expired = true;

            $('#submitModal').modal('show');
        }

    },

    created() {
        this.userAnswers = this.examableuser.answers
        this.getExamInfo();
    },

    computed: {
        questionNumber() {
            return this.questionIds.indexOf(this.currentQuestionId) + 1
        },

        isPrevDisabled() {
            return (this.prevQuestion == 0) ? 'disabled' : '';
        },

        isNextDisabled() {
            return (this.nextQuestion == 0) ? 'disabled' : '';
        },

        chosen() {
            return (this.userAnswers[this.currentQuestionId] == '') ? 'disabled' : '';
        },

        savingAnswer() {
            return (this.answering) ? 'btn-loading' : '';
        },

        isSubmitting() {
            return (this.submitting) ? 'active' : '';
        },

        hasilUrl() {
            return '/k/' + this.kelas + '/u/' + this.examData.slug + '/hasil?attempt=' + this.examableuser.attempt;
        }

    },

}
</script>