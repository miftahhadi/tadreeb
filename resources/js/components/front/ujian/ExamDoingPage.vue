<template>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Soal ke-{{ questionNumber }} dari {{ exam.questions_count}}</h3>
                </div>

                <div class="card-body" v-html="question.konten" :key="soalKey">
                </div>

                <div class="card-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-white">
                            <i class="fas fa-chevron-circle-left"></i>
                            <span class="ml-1">Sebelumnya</span>
                        </a>

                        <a href="#" class="btn btn-success">Jawab</a>
                        
                        <a href="#" class="btn btn-white">
                            <span class="mr-1">Lewati</span>
                            <i class="fas fa-chevron-circle-right"></i>
                        </a>
                    </div>
                    
                </div>

            </div>
        </div>

        <div class="col-md-5">
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
                            @showQuestion="question($event)"
                        ></exam-number-button>

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
        examId: Number
    },

    data() {
        return {
            exam: {},
            questionIds: [],
            questionId: 0,
            question: {},
            answers: [],
            soalKey: 0,
        }
    },

    methods: {
        getExamInfo() {
            axios.get('/api/ujian/' + this.examId)
                    .then(response => {
                        this.exam = response.data.exam
                        this.questionIds = response.data.questionIds
                        this.questionId = response.data.questionIds[0]

                        this.getQuestion()
                    })
                    .catch(error => {
                        console.log(error)
                    });
        },

        getQuestion() {
            axios.get('/api/soal/' + this.questionId)
                    .then(response => {
                        this.question = response.data.soal
                        this.answers = response.data.answers
                    })
                    .catch(error => {
                        console.log(error);
                    });
        },

        question(id) {
            this.questionId = id;
            this.getQuestion

            this.reloadSoal()
        },

        isCurrent(id) {

        },

        reloadSoal() {
            return this.soalKey++
        }
    },

    created() {
        this.getExamInfo();
    },

    computed: {
        questionNumber() {
            return this.questionIds.indexOf(this.questionId) + 1
        }
    }

}
</script>