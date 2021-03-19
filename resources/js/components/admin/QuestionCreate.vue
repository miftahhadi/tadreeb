<template>
    <div>
        <div class="row my-2">
            <div class="col-auto">
                <h2>Buat soal baru</h2>
            </div>
            
        </div>
        
        <div class="card mb-3">
            <div class="card-body form-group row">
                <label class="form-label col-auto col-form-label">Tipe soal:</label>
                <div class="col-auto">
                    <select class="form-select" v-model="tipe">
                        <option v-for="opsi in typeOptions" :key="opsi.id" :value="opsi.value">{{ opsi.text }}</option>
                    </select>
                </div>

                <div class="col-auto ml-auto">
                    <input type="submit" value="Simpan" class="btn btn-success">
                    <a href="#" class="btn btn-white">Batal</a>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Redaksi Soal
            </div>
            <div class="card-body">
        
                <small class="text-danger">Soal belum diisi</small>
        
                <textarea class="form-control" name="soal[konten]" id="redaksi" placeholder="Tuliskan soal..."></textarea>
            </div>
        </div>

        <hr>

        <h3>Pilihan Jawaban</h3>

        <div class="card mb-4" v-for="(i,index) in answersNum" :key="index">
            <div class="card-header">
                Pilihan {{ i }}
            </div>

            <div class="card-body" id="cardSoal">
                <textarea name="jawaban[][redaksi]" v-model="answers[index].redaksi"></textarea>
            </div> 
            
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-label">Pilihan Benar</div>
                            <label class="form-check">
                                <input :type="inputType" class="form-check-input" name="jawaban[][benar]" value="1">
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

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <label class="form-check">
                            <input type="radio" 
                                    class="form-check-input" 
                                    name="jawaban[1][benar]" 
                                    value="1"
                            >
                            
                            <input type="hidden" 
                                    name="jawaban[1][redaksi]" 
                                    value=""
                            >

                            <div class="form-check-label">Benar</div>
                        </label>
                    </div>
    
                    <div class="card-footer">
    
                        <div class="form-group">
                            <label class="form-label">Nilai</label>
                            
                            <input type="number" 
                                    class="form-control" 
                                    placeholder="Nilai" 
                                    value="0" 
                                    name="jawaban[1][nilai]"
                            >
                        </div>
        
                    </div>
    
                </div>
            </div>
    
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <label class="form-check">
                            <input type="radio" 
                                    class="form-check-input" 
                                    name="jawaban[2][benar]" 
                                    value="1"
                            >
                            
                            <input type="hidden" 
                                    name="jawaban[2][redaksi]" 
                                    value=""
                            >
                            
                            <div class="form-check-label">Salah</div>
                        </label>
                    </div>
    
                    <div class="card-footer">
                        
                        <div class="form-group">
                            <label class="form-label">Nilai</label>
                            <input type="number" class="form-control" placeholder="Nilai" value="0" name="jawaban[2][nilai]">
                        </div>
    
                    </div>
    
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'question-create',

    props: {

    },

    data() {
        return {
            tipe: 'pilihan-ganda',
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
                    benar: null,
                    nilai: 0
                },
                {
                    redaksi: '',
                    benar: null,
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
                        benar: null,
                        nilai: 0
                    },
                    {
                        redaksi: this.benarSalahOptions.reguler.salah,
                        benar: null,
                        nilai: 0
                    }
                ]
            } else if (newTipe == 'benar-salah-arabic') {
                this.answers = [
                        {
                            redaksi: this.benarSalahOptions.arabic.benar,
                            benar: null,
                            nilai: 0
                        },
                        {
                            redaksi: this.benarSalahOptions.arabic.salah,
                            benar: null,
                            nilai: 0
                        }
                    ]   
            }
        },
    },

    computed: {
        inputType() {
            return (this.tipe == 'jawaban-ganda') ? 'checkbox' : 'radio'
        }
    }
}
</script>