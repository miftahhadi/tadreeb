<template>
    <div>
        <item-list
            item="kelas"
            :fetch-url="'/api/ujian/' + examId + '/kelas'"
            :table-heading="tableHeading"
            :item-properties="itemProperties"
            :action="true"
            ref="list"
        >
            <template v-slot:action="actionProp">
                <div class="btn-list flex-nowrap">

                    <button 
                        class="btn btn-sm" 
                        data-toggle="modal"
                        data-target="#kelasSettingModal"
                        @click="getSetting(actionProp.index)"
                    >Pengaturan</button>
                    
                    <a :href="'/admin/ujian/' + examId + '/kelas?kelas=' + actionProp.item.id + '&page=hasil' " class="btn btn-sm">Hasil</a>
                </div>
            </template>
        </item-list>

        <kelas-item-setting-modal
            item="kelas"
            ref="settingModal"
            @save:setting="updateSetting"
        ></kelas-item-setting-modal>
    </div>
</template>

<script>
    import { DateTime } from "luxon";
    import swal from "sweetalert";

    export default {
        name: 'exam-kelas',

        props: {
            examId: Number,
            tableHeading: Array,
            itemProperties: Array
        },

        data() {
            return {
                setting: null,
                settingId: null,
                kelasId: null,

                dt: ['buka_otomatis', 'tampil_otomatis', 'batas_buka']
            }
        },

        methods: {
            getSetting(id) {
                const setting = this.$refs.settingModal.input
                const data = this.$refs.list.laravelData.data[id].pivot

                this.settingId = id
                this.kelasId = this.$refs.list.laravelData.data[id].id

                for (let key in setting) {
                    if (this.dt.includes(key) && data[key] != null) {
                        const datetime = DateTime.fromISO(data[key]).setZone('UTC+7')
                        
                        this.$refs.settingModal.input[key] = {
                            tanggal: datetime.toFormat('yyyy-LL-dd'),
                            waktu: datetime.toFormat('HH:mm')
                        }
                    } else if (this.dt.includes(key) && data[key] == null) {
                        this.$refs.settingModal.input[key] = {
                            tanggal: null,
                            waktu: '00:00'
                        }
                    } else {
                        this.$refs.settingModal.input[key] = data[key]
                    }
                }
            },

            updateSetting(setting) {
                const data = this.$refs.list.laravelData.data[this.settingId].pivot

                for (let key in setting) {
                    if (this.dt.includes(key) && setting[key].tanggal != '') {
                        const datetime = DateTime.fromISO(setting[key].tanggal + 'T' + setting[key].waktu, {zone: 'UTC+7'})
                        const newdt = datetime.setZone('utc')

                        data[key] = newdt.toISO()
                    } else if (this.dt.includes(key) && setting[key].tanggal == '') {
                        data[key] = null
                    } else {
                        data[key] = setting[key]
                    }
                }

                axios.post('/api/ujian/setting', {
                    examId: this.examId,
                    kelasId: this.kelasId,
                    setting: data
                }).then(response => {
                    swal({
                        title: "Data berhasil dihapus",
                        icon: "success",
                    });
                }).catch(error => {
                    console.log(error)
                })
            }
        },

    }
</script>