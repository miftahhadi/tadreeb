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
                    :kelas-id="kelasId"
                    :key="key.lesson"
                ></item-assigned>

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
                    :kelas-id="kelasId"
                    :key="key.exam"
                    @show:setting="showExamSetting($event)"
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
                    :kelas-id="kelasId"
                    :key="key.user"
                ></item-assigned>

            </tab-details>

            <tab-details name="Pengaturan">
                <h2>Pengaturan</h2>
            </tab-details>

        </item-tab>

        <kelas-assign-modal
            item="ujian"
            :kelas="kelas"
            :headings="examData.heading"
            fetch-url="/api/ujian"
            :item-properties="examData.props"
            :assign-url="examData.fetchUrl + '/assign'"
            :assigned="examData.assigned"
            @saved="key.exam += 1"
        ></kelas-assign-modal>

        <kelas-assign-modal
            item="pelajaran"
            :kelas="kelas"
            :headings="lessonData.heading"
            fetch-url="/api/pelajaran"
            :item-properties="lessonData.props"
            :assign-url="lessonData.fetchUrl + '/assign'"
            :assigned="lessonData.assigned"
            @saved="key.lesson += 1"
        ></kelas-assign-modal>

        <kelas-assign-modal
            item="user"
            :kelas="kelas"
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
    </div>
</template>

<script>
import { DateTime } from "luxon";
import swal from "sweetalert";
import ItemAssigned from '../item-index/ItemAssigned.vue';

export default {
  components: { ItemAssigned },
    name: 'kelas-index',
    
    props: {
        kelas: String,
        kelasId: Number,
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
        }
    },

    mounted() {
        this.DateTime = DateTime;
    },

    methods: {
        showExamSetting(id) {
            this.examId = id
            this.loadingSetting = true,

            axios.get('/api/ujian/' + this.examId + '/setting?kelas=' + this.kelasId)
                    .then(response => {
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
                kelasId: this.kelasId,
                setting: data
            }).then(response => {
                swal({
                    title: "Pengaturan berhasil disimpan",
                    icon: "success",
                });
            }).catch(error => {
                console.log(error)
            })
        } 
    }
}
</script>