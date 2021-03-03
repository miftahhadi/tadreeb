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
            }
        },

        methods: {
            getSetting(id) {
                this.settingId = id

                const data = this.$refs.list.laravelData.data[id].pivot
                const keys = Object.keys(data)

                const datetime= ['buka_otomatis', 'tampil_otomatis', 'batas_buka']

                keys.forEach(function (key) {
                    if (datetime.includes(key) && data[key] != null) {
                        const datetime = DateTime.fromISO(data[key])
                        
                        data[key] = {
                            tanggal: datetime.toFormat('yyyy-LL-dd'),
                            waktu: datetime.toFormat('HH:mm')
                        }
                    } else if (datetime.includes(key) && data[key] == null) {
                        data[key] = {
                            tanggal: null,
                            waktu: '00:00'
                        }
                    }
                })

                this.$refs.settingModal.input = data
            },

            updateSetting(setting) {
                const data = this.$refs.list.laravelData.data[this.settingId].pivot
                const keys = Object.keys(data)

                keys.forEach(function (key) {
                    if (this.datetime.includes(key) && setting[key].tanggal != '') {
                        const datetime = DateTime.fromISO(data[key].tanggal + 'T' + data[key].waktu, {zone: '+07:00'})

                        data[key] = datetime.toSQL()
                    } else if (this.datetime.includes(key) && setting[key].tanggal == '') {
                        data[key] = null
                    } else {
                        data[key] = setting[key]
                    }
                })
                console.log(data)
            }
        },

    }
</script>