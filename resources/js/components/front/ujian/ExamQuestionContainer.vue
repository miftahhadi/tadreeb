<template>
    <div class="card">

        <div class="dimmer" :class="isLoading">

            <div class="loader"></div>

            <div class="dimmer-content">

                <div class="card-header">
                    <h3 class="card-title">Soal ke-{{ questionNumber }} dari {{ questionsCount}}</h3>
                </div>

                <div class="card-body" v-html="question.konten">
                </div>

                <div class="card-body">
                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">


                        <label class="form-selectgroup-item flex-fill" v-for="answer in answers" :key="answer.id">
                            
                            <input :type="type" 
                                :value="answer.id" 
                                class="form-selectgroup-input"
                                v-model="thisAnswer"
                            >

                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                                <div class="mr-3">
                                    <span class="form-selectgroup-check"></span>
                                </div>
                                <div v-html="answer.redaksi">
                                </div>
                            </div>
                        </label>


                    </div>
                </div>

                <div class="card-footer">
                    <div class="btn-list">
                        <button class="btn btn-white" 
                                v-if="prevQuestion != 0"
                                @click="getPrevQuestion"
                        >
                            <i class="fas fa-chevron-circle-left"></i>
                            <span class="ml-1">Sebelumnya</span>
                        </button>

                        <button class="btn btn-success"
                                :class="isAnswering" 
                                @click="updateAnswer"
                        >Jawab</button>
                        
                        <button class="btn btn-white" 
                                v-if="nextQuestion != 0"
                                @click="getNextQuestion"
                        >
                            <span class="mr-1">Lewati</span>
                            <i class="fas fa-chevron-circle-right"></i>
                        </button>
                    </div>
                    
                </div>

            </div>

        </div>

    </div>
</template>

<script>
export default {
    name: 'exam-question-container',

    props: {
        questionNumber: Number,
        questionsCount: Number,
        question: Object,
        questionId: Number,
        answers: Array,
        userAnswers: Object,
        type: String,
        loading: Boolean,
        nextQuestion: Number,
        prevQuestion: Number,
        answering: Boolean,
    },

    data() {
        return {
            thisAnswer: null,
        }
    },

    computed: {
        isLoading() {
            return (this.loading) ? 'active' : '';
        },

        isAnswering() {
            return (this.answering) ? 'btn-loading' : '';
        }
    },

    methods: {
        getNextQuestion() {
            this.$emit('get:next')
        },

        getPrevQuestion() {
            this.$emit('get:prev')
        },

        updateAnswer() {
            this.$emit('update:answer', this.thisAnswer)
        },

    }
}
</script>