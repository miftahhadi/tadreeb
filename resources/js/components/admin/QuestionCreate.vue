<template>
    <div>        
        <slot name="csrf"></slot>

        <div class="card mb-3">
            <div class="card-header">
                <div class="col-auto">
                    <span class="card-title">
                        Buat soal baru
                    </span>
                </div>

                <div class="col-auto ml-auto">
                    <button class="btn btn-success" @click="save()">Simpan</button>
                    <!-- <input type="submit" value="Simpan" class="btn btn-success"> -->
                    <a :href="'/admin/ujian/' + examId " class="btn btn-white">Kembali</a>
                </div>

            </div>
            <div class="card-body form-group row">
                <div class="col-md-4 row">
                    <label class="form-label col-auto col-form-label">Tipe soal:</label>
                    <div class="col-auto">
                        <select class="form-select" v-model="question.tipe" name="tipe">
                            <option v-for="opsi in typeOptions" :key="opsi.id" :value="opsi.value">{{ opsi.text }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 row">
                    <label class="form-label col-auto col-form-label">Kode soal (opsional):</label>
                    <div class="col-auto">
                        <input type="text" class="form-control" v-model="question.kode" placeholder="misal: nhw21a" name="kode">
                    </div>
                </div>

                <div class="col-md-4 row">
                    <label class="form-label col-auto col-form-label">ID soal:</label>
                    <div class="col-auto">
                        <input type="text" class="form-control" v-model="question.id" name="kode" disabled>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Redaksi Soal
            </div>
            <div class="card-body">
        
                <small class="text-danger">Soal belum diisi</small>
        
                <ckeditor v-model="question.konten" :editor-url="editorUrl" name="redaksiSoal"></ckeditor>

            </div>
        </div>

        <hr>

        <h3>Pilihan Jawaban</h3>

        <div class="card mb-4" v-for="(i,index) in answersNum" :key="index">
            <div class="card-header">
                <div class="col-auto">
                    Pilihan {{ i }}
                </div>
                <div class="col-auto ml-auto">
                    <button class="btn btn-sm text-danger" @click="deleteAnswer(index)">Hapus</button>
                </div>
            </div>

            <div class="card-body" id="cardSoal">
                <ckeditor v-model="answers[index].redaksi" :editor-url="editorUrl" :name="'jawaban[' + index + '][benar]'"></ckeditor>
                <!-- <textarea name="jawaban[][redaksi]" v-model="answers[index].redaksi"></textarea> -->
            </div> 
            
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-label">Pilihan Benar</div>
                            <label class="form-check">
                                <input :type="inputType" class="form-check-input" :name="'jawaban[' + index + '][benar]'" :value="index" v-model="jawabanBenar">
                                <span class="form-check-label">Benar</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Nilai</label>

                            <input 
                                type="number" 
                                class="form-control" 
                                name="jawaban[][nilai]" 
                                placeholder="Nilai" 
                                value="0"
                                v-model="answers[index].nilai"
                            >

                        </div>
                    </div>  

                </div>
            </div>

        </div>

        <button class="btn btn-square" @click="addAnswer()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><line x1="9" y1="12" x2="15" y2="12" /><line x1="12" y1="9" x2="12" y2="15" /></svg>
            Tambah jawaban
        </button>

    </div>
</template>

<script>
import swal from "sweetalert";

export default {
    name: 'question-create',

    props: {
        examId: Number,
        questionModel: Object,
    },

    data() {
        return {
            question: {
                id: null,
                kode: null,
                tipe: 'pilihan-ganda',
                konten: null
            },
            editorUrl: '/dist/vendor/ckeditor/ckeditor.js',

            typeOptions: [
                {
                    text: 'Pilihan Ganda',
                    value: 'pilihan-ganda'
                },
                
                {
                    text: 'Jawaban Ganda',
                    value: 'jawaban-ganda'
                },

                {
                    text: 'Benar-Salah',
                    value: 'benar-salah'
                },

                {
                    text: 'Benar-Salah (Arabic)',
                    value: 'benar-salah-arabic'
                },
            ],

            benarSalahOptions: {
                reguler: {
                    benar: 'Benar',
                    salah: 'Salah'
                },

                arabic: {
                    benar: 'صحيح',
                    salah: 'خطأ'
                }
            },

            answersNum: 2,

            answers: [
                {
                    redaksi: '',
                    nilai: 0
                },
                {
                    redaksi: '',
                    nilai: 0
                }
            ],

            jawabanBenar: null,

        }
    },

    watch: {
        tipe: function (newTipe, oldTipe) {
            if (newTipe == 'benar-salah') {
                this.answersNum = 2

                this.answers = [
                    {
                        redaksi: this.benarSalahOptions.reguler.benar,
                        nilai: 0
                    },
                    {
                        redaksi: this.benarSalahOptions.reguler.salah,
                        nilai: 0
                    }
                ]
            } else if (newTipe == 'benar-salah-arabic') {
                this.answersNum = 2

                this.answers = [
                        {
                            redaksi: '<span dir="rtl" lang="ar" style="font-family:Scheherazade;font-size:24px">' + this.benarSalahOptions.arabic.benar + '</span>',
                            nilai: 0
                        },
                        {
                            redaksi: '<span dir="rtl" lang="ar" style="font-family:Scheherazade;font-size:24px">' + this.benarSalahOptions.arabic.salah + '</span>',
                            nilai: 0
                        }
                    ]   
            } else if (newTipe == 'jawaban-ganda') {
                this.jawabanBenar = [];
            }
        },
    },

    methods: {
        addAnswer() {
            this.answersNum += 1;

            const answer = {
                redaksi: '',
                nilai: 0
            }

            this.answers.push(answer)
        },

        deleteAnswer(index) {
            this.answersNum -= 1

            this.answers.splice(index, 1)
            
            if (this.question.tipe == 'jawaban-ganda' && this.jawabanBenar.includes(index)) {
                this.jawabanBenar.splice(index,1)
            } else if (this.question.tipe != 'jawaban-ganda' && this.jawabanBenar == index) {
                this.jawabanBenar = null
            }
        },

        save() {
            for (let i = 0; i < this.answers.length; i++) {
                if (this.question.tipe == 'jawaban-ganda' && this.jawabanBenar.includes(i)) {
                    this.answers[i].benar = 1
                } else if (this.question.tipe != 'jawaban-ganda' && this.jawabanBenar == i) {
                    this.answers[i].benar = 1
                } else {
                    this.answers[i].benar = 0
                }
            }

            const question = this.question;

            switch (question.tipe) {
                case 'pilihan-ganda':
                    question.tipe = 1;
                    break;

                case 'jawaban-ganda':
                    question.tipe = 2;
                    break;
                
                case 'benar-salah', 'benar-salah-arabic':
                    question.tipe = 3;
                    break;
            }

            axios.post('/api/soal', {
                examId: this.examId,
                question: question, 
                answers: this.answers,
            }).then(response => {
                swal("Data berhasil disimpan!", "Anda bisa kembali ke halaman sebelumnya atau tetap di sini untuk mengedit soal", "success")

                this.processData(response.data)
            }).catch(errors => {
                console.log(errors)
            })
        },

        processData(data) {
            this.question = data.question;
            const types = {
                1: 'pilihan-ganda',
                2: 'jawaban-ganda',
                3: 'benar-salah'
            }
            
            this.question.tipe = types[data.question.tipe];

            this.answers = data.answers

            this.answersNum = data.answers.length

            for (let i = 0; i < data.answers.length; i++) {
                if (data.answers[i].benar == 1 && this.question.tipe == 'jawaban-ganda') {
                    this.jawabanBenar.push(i);
                } else if (data.answers[i].benar == 1 && this.question.tipe != 'jawaban-ganda') {
                    this.jawabanBenar = i;
                }
            }

        }
    },

    computed: {
        inputType() {
            return (this.question.tipe == 'jawaban-ganda') ? 'checkbox' : 'radio'
        },

        submitUrl() {
            return '/admin/ujian/' + this.examId + '/soal';
        }
    },
}
</script>