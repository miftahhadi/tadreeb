<template>
    <div>
        <item-tab>

            <tab-details name="Ikhtisar" :selected="true">
                <h2>Ikhtisar</h2>
            </tab-details>

            <tab-details name="Pelajaran">

                <div class="row">
                    <div class="col">
                        <h2>Pelajaran</h2>
                    </div>

                    <div class="col-auto ml-auto">
                        <button class="btn btn-primary" 
                                data-toggle="modal" 
                                data-target="#assignPelajaranModal"
                        >Tambah Pelajaran</button>
                    </div>
                </div>

                <item-assigned
                    item="pelajaran"
                    :item-data="lessonData"
                    :kelas-id="kelas.id"
                    :key="key.lesson"
                    setting="pelajaranSettingModal"
                >
                </item-assigned>

            </tab-details>

            <tab-details name="Ujian">

                <div class="row">
                    <div class="col">
                        <h2>Ujian</h2>
                    </div>

                    <div class="col-auto ml-auto">
                        <button class="btn btn-primary" 
                                data-toggle="modal" 
                                data-target="#assignUjianModal"
                        >Tambah Ujian</button>
                    </div>
                </div>

                <item-assigned
                    item="ujian"
                    :item-data="examData"
                    :kelas-id="kelas.id"
                    setting="ujianSettingModal"
                    :key="key.exam"
                ></item-assigned>

            </tab-details>

            <tab-details name="Anggota">

                <div class="row">
                    <div class="col">
                        <h2>Anggota</h2>
                    </div>

                    <div class="col-auto ml-auto">
                        <button class="btn btn-primary" 
                                data-toggle="modal" 
                                data-target="#assignAnggotaModal"
                        >Tambah Anggota</button>
                    </div>
                </div>

                <item-assigned
                    item="user"
                    :item-data="userData"
                    :kelas-id="kelas.id"
                    :key="key.user"
                ></item-assigned>

            </tab-details>

            <tab-details name="Pengaturan">
                <h2>Pengaturan</h2>
            </tab-details>

        </item-tab>

        <kelas-assign-modal
            item="ujian"
            :kelas="kelas.nama"
            :headings="examData.heading"
            fetch-url="/api/ujian"
            :item-properties="examData.props"
            :assign-url="examData.fetchUrl + '/assign'"
            :assigned="examData.assigned"
            @saved="key.exam += 1"
        ></kelas-assign-modal>

        <kelas-assign-modal
            item="pelajaran"
            :kelas="kelas.nama"
            :headings="lessonData.heading"
            fetch-url="/api/pelajaran"
            :item-properties="lessonData.props"
            :assign-url="lessonData.fetchUrl + '/assign'"
            :assigned="lessonData.assigned"
            @saved="key.lesson += 1"
        ></kelas-assign-modal>

        <kelas-assign-modal
            item="user"
            :kelas="kelas.nama"
            :headings="userData.heading"
            fetch-url="/api/user"
            :item-properties="userData.props"
            :assign-url="userData.fetchUrl + '/assign'"
            :assigned="userData.assigned"
            @saved="key.user += 1"
        ></kelas-assign-modal>

        <kelas-item-setting-modal
            ref="examSettingModal"
            item="ujian"
            :loading="loadingSetting"
            :timezone="tzName"
            @save:setting="saveExamSetting"
        ></kelas-item-setting-modal>

        <kelas-item-setting-modal
            ref="lessonSettingModal"
            item="pelajaran"
            :loading="loadingSetting"
            :timezone="tzName"
        ></kelas-item-setting-modal>

        <modal
            id="unassignItemModal"
            :classes="['modal-dialog-centered']"
        >
            <template #header>
                Hapus item dari kelas
            </template>

            <template #body>
                Apakah Anda yakin menghapus item ini dari kelas {{ kelas.nama }}? Semua data kelas {{ kelas.nama }} terkait item ini akan hilang
            </template>

            <template #footer>
                <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Batal</button>
                
                <button 
                    type="button" 
                    class="btn btn-danger" 
                    data-dismiss="modal"
                    @click="unassignItem()"
                >Ya, hapus</button>
            </template>

        </modal>
    </div>
</template>

<script>
import { DateTime } from "luxon";
import swal from "sweetalert";

export default {
    name: 'kelas-index',
    
    props: {
        kelas: Object,
        lessonData: Object,
        examData: Object,
        userData: Object,
        tzName: String
    },

    data() {
        return {
            key: {
                lesson: 0,
                exam: 0,
                user: 0,
            },

            examId: null,
            lessonId: null,

            loadingSetting: false,

            itemToUnassign: {},
            deleteKey: 0
        }
    },

    mounted() {
        this.DateTime = DateTime;
    },

    methods: {
        showExamSetting(id) {
            this.resetSetting()

            this.examId = id
            this.loadingSetting = true,

            axios.get('/api/ujian/' + this.examId + '/setting?kelas=' + this.kelas.id)
                    .then(response => {
                        console.log(response.data)
                        if (response.data != 0) {
                            this.$refs.examSettingModal.input = response.data
                        }
                        this.loadingSetting = false
                    }).catch(error => {
                        console.log(error)
                    })

        },

        saveExamSetting(data) {
            axios.post('/api/ujian/setting', {
                examId: this.examId,
                kelasId: this.kelas.id,
                setting: data
            }).then(response => {
                swal({
                    title: "Pengaturan berhasil disimpan",
                    icon: "success",
                });
            }).catch(error => {
                console.log(error)
            })
        },

        resetSetting() {
            let setting = this.$refs.examSettingModal.input

            const props = Object.keys(setting)

            for (let key of props) {
                if (typeof setting[key] === 'object') {
                    setting[key].tanggal = null
                    setting[key].waktu = '00:00'
                } else {
                    setting[key] = null
                }
            }
        },

        unassignItem() {
            const url = '/api/kelas/' + this.kelas.id + '/' + this.itemToUnassign.type + '/unassign';

            axios.post(url, {
                item: this.itemToUnassign.data
            }).then(response => {
                this.key.exam += 1
            }).catch(error => {
                console.log(error)
            })
        }
    },

    created() {
        EventBus.$on('callSetting', data => {
            if (data.item == 'ujian') {
                this.showExamSetting(data.id)
            }
        });

        EventBus.$on('callUnassign', data => {
            this.itemToUnassign.type = data.item
            this.itemToUnassign.data = data.itemData
        })
    }
}
</script>