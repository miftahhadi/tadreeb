<template>
    <div>
        <div class="row mb-2">
            <div class="col-auto">
                <h2>Daftar Soal</h2>
            </div>    
            <div class="col-auto ml-auto">

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahSoal">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>    
                    </span> 
                    Buat Soal Baru
                </button>  

            </div>
        </div>

        <div class="card">
            <v-table
                :headings="headings"
                :properties="properties"
                :item-data="questions"
                :action="true"
            >
                <template v-slot:action="slotProp">
                    <div class="btn-list flex-nowrap">
                        <button 
                            class="btn btn-light btn-sm"
                            data-toggle="modal"
                            data-target="#viewQuestionModal"
                            @click="callView(slotProp.item)"
                        >Lihat</button>

                        <a :href="'/admin/ujian/' + examId + '/soal/' + slotProp.item.id + '/edit' " class="btn btn-light btn-sm" target="_blank">Edit</a>
                        
                        <button 
                            class="btn btn-danger btn-sm"
                            data-toggle="modal"
                            data-target="#unassignQuestionModal"
                            @click="callUnassign(slotProp.item)"
                        >Buang</button>
                    </div>
                </template>
            </v-table>
        </div>

        <modal
            id="unassignQuestionModal"
            :classes="['modal-dialog-centered']"
        >
            <template #header>
                Hapus soal 
            </template>

            <template #body>
                Apakah Anda yakin menghapus soal ini?
            </template>

            <template #footer>
                <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Batal</button>
                
                <button 
                    type="button" 
                    class="btn btn-danger" 
                    data-dismiss="modal"
                    @click="unassign()"
                >Ya, hapus</button>
            </template>

        </modal>

        <modal
            id="viewQuestionModal"
            :classes="['modal-dialog-centered', 'modal-lg']"
        >
            <template #header v-if="toView">
                <span>
                    ID Soal: {{ toView.id }}
                </span>
                <a :href="'/admin/ujian/' + examId + '/soal/' + toView.id + '/edit' " class="btn" target="_blank">Edit</a>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </template>

            <template #body>
                <span v-html="toView.konten" v-if="toView != null"></span>
            </template>

            <template #extended-body v-if="toView != null">
                <div class="table-responsive border-top">
                    <table class="table card-table table-vcenter">
                        <tbody>
                            <tr v-for="answer in toView.answers" :key="answer.id">
                                <td class="w-1 text-success" :class="(answer.benar == 1) ? 'text-success' : 'text-danger'">
                                    <i class="fas fa-check-circle fa-lg" v-if="answer.benar == 1"></i>
                                    <i class="fas fa-times-circle fa-lg" v-else></i>
                                </td>
                                <td v-html="answer.redaksi"></td>
                                <td width="20%"><b>Nilai:</b> {{ answer.nilai }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>

        </modal>

    </div>
</template>

<script>
import swal from "sweetalert";

export default {
    name: 'exam-question',

    props: {
        examId: Number,
        questionsArray: Array
    },

    data() {
        return {
            headings: [
                {
                    id: 0,
                    width: '5%',
                    name: 'No'
                },
                {
                    id: 1,
                    width: '60%',
                    name: 'Soal'
                },
                {
                    id: 2,
                    width: null,
                    name: 'Tipe',
                }
            ],

            properties: ['urutan', 'konten', 'tipe'],

            toUnassign: null,
            toView: null,

            questions: this.questionsArray
        }
    },

    methods: {
        callUnassign(item) {
            this.toUnassign = item
        },

        unassign() {
            const id = this.questions.indexOf(this.toUnassign)
            const urutan = this.toUnassign.urutan

            axios.post('/api/ujian/unassign-soal', {
                examId: this.examId,
                soalId: this.toUnassign.id
            }).then(response => {
                this.questions.splice(id, 1)

                this.questions.map(question => {
                    if (question.urutan > urutan) {
                        question.urutan -= 1
                    }
                })

                swal({
                    title: "Data berhasil dihapus",
                    icon: "success",
                });
            }).catch(errors => {
                console.log(errors)
            })
        },

        callView(item) {
            this.toView = item
        }
    }
}
</script>

<style>
p {
    margin-bottom: 0rem;
}
</style>