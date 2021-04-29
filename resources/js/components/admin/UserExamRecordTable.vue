<template>
    <div>
        <div class="mb-2">
            <h2 class="text-center mb-2">Riwayat Pengerjaan</h2>
            <div>Nama:  {{ user.name }} </div>
            <div>Username: {{ user.username }}</div>
        </div>

        <div class="card">
            <v-table
                :headings="headings"
                :properties="properties"
                :item-data="records"
                :action="true"
            >
                <template v-slot:action="actionProps">
                    <div class="d-flex small">
                        <a href="#" class="btn btn-sm btn-link mx-1">Lihat</a>
                        <a href="#" 
                            class="btn btn-sm btn-danger" 
                            data-toggle="modal" 
                            data-target="#deleteModal"
                            @click="callDelete(actionProps.index)"
                        >
                            Hapus
                        </a>
                    </div>
                </template>
            </v-table>
        </div>
        
        <modal
            id="deleteModal"
            :classes="['modal-dialog-centered', 'modal-sm']"
        >
            <template #body>
                <div class="text-center py-2">
                    <h3>Apakah Anda yakin?</h3>

                    <div class="text-muted">Apakah Anda benar-benar ingin menghapus data ini? Jika dilakukan, data tidak bisa dikembalikan seperti semula</div>
                </div>
            </template>

            <template #footer>
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn btn-white w-100" data-dismiss="modal">
                                Batal
                            </a>
                        </div>
                        <div class="col">
                            <button 
                                class="btn btn-danger w-100" 
                                data-dismiss="modal"
                                @click="deleteRecord()"
                            >
                                Ya, hapus data
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </modal>

    </div>
</template>

<script>
import swal from "sweetalert";

export default {
    name: 'user-exam-record-table',

    props: {
        data: Array,
        user: Object
    },

    data() {
        return {
            headings: [
                {
                    name: 'Ke-',
                    width: null
                },
                {
                    name: 'Mulai mengerjakan',
                    width: null
                },
                {
                    name: 'Selesai mengerjakan',
                    width: null
                },
                {
                    name: 'Durasi',
                    width: null
                },
                {    
                    name: 'Nilai',
                    width: null
                }
            ],

            properties: ['attempt', 'waktu_mulai', 'waktu_selesai', 'durasi', 'score'],
            records: [],

            toDelete: {}
        }
    },

    methods: {
        callDelete(id) {
            this.toDelete = this.records[id]
        },

        deleteRecord() {
            axios.delete('/api/user-exam-record/' + this.toDelete.examable_user_id)
                    .then(response => {
                        if (response.data == 1) {
                            index = this.records.indexOf(this.toDelete)

                            this.records.splice(index, 1)
                            swal({
                                title: "Data berhasil dihapus",
                                icon: "success",
                            });                            
                        } else {
                            swal({
                                title: "Data gagal dihapus",
                                text: "Terjadi kesalahan sistem, hubungi admin sistem Anda",
                                icon: "error",
                            });
                        }

                    }).catch(errors => {
                        console.log(errors)
                    })
        }
    },

    created() {
        this.records = this.data
    }
}
</script>