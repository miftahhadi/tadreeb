<template>
    <div>
        <div class="row mb-2">
            <div class="col-auto">
                <h2>Daftar Soal</h2>
            </div>    
            <div class="col-auto ml-auto">               
                <a :href="'/admin/ujian/' + examId + '/soal/create'" class="btn btn-primary">Buat Soal Baru</a>
                <button 
                    class="btn"
                    data-toggle="modal" 
                    data-target="#assignQuestionModal"
                >Impor dari database</button>
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
            id="assignQuestionModal"
            :classes="['modal-dialog-centered', 'modal-lg']"
        >
            <template #header>
                Impor soal dari database
            </template>

            <template #body>
                <item-list
                    :table-heading="assignModal.headings"
                    :item-properties="assignModal.properties"
                    fetch-url="/api/soal"
                    :search="true"
                    :key="listKey"
                >
                    <template v-slot:action="actionProp">
                        <item-assign
                            item-type="question"
                            :item-id="actionProp.item.id"
                            :assign-url="'/api/ujian/' + examId + '/assign-soal'"
                            :assigned="questionIds.includes(actionProp.item.id)"
                        ></item-assign>
                    </template>
                </item-list>
            </template>

        </modal>

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
                <div class="table-responsive border-top p-3">
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
                    id: 2,
                    width: null,
                    name: 'Kode'
                },
                {
                    id: 3,
                    width: '60%',
                    name: 'Soal'
                },
                {
                    id: 4,
                    width: null,
                    name: 'Tipe',
                }
            ],

            properties: ['urutan', 'kode', 'konten', 'tipe'],

            toUnassign: null,
            toView: null,

            questions: this.questionsArray,
            questionIds: [],

            assignModal: {
                headings: [
                    {
                        id: 0,
                        width: null,
                        name: 'ID'
                    },
                    {
                        id: 1,
                        width: null,
                        name: 'Kode'
                    },
                    {
                        id: 2,
                        width: '60%',
                        name: 'Soal'
                    }
                ],

                properties: ['id', 'kode', 'konten'],

                listKey: 0,
            }
        }
    },

    methods: {
        assign(data) {
            this.questions.push(data)
            this.questionIds.push(data.id)
        },

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
                this.questionIds.splice(id, 1)

                this.listKey += 1

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
    },

    created() {
        this.questionsArray.forEach(question => {
            this.questionIds.push(question.id)
        })

        EventBus.$on('item:assigned', (response) => {
            this.assign(response.data)
        })
    }
}
</script>

<style>
p {
    margin-bottom: 0rem;
}
</style>