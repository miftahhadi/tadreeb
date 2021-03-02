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
        ></kelas-item-setting-modal>
    </div>
</template>

<script>
    import { DateTime } from "luxon";
import ConfirmsPasswordVue from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/ConfirmsPassword.vue';

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

                let result = {}

                const datetime = ['buka_otomatis', 'tampil_otomatis', 'batas_buka']

                keys.forEach((key) => {
                    console.log(key)
                    console.log(typeof data[key])
                    if (datetime.includes(key) && typeof data[key] != 'null') {
                        const datetime = DateTime.fromSQL(data[key])
                        
                        data[key] = {
                            tanggal: datetime.toFormat('yyyy-LL-dd'),
                            waktu: datetime.toFormat('HH:mm')
                        }
                    } 
                })

                console.log(data)
        
            },

            formatDate() {

            },

            updateSetting(data) {

            }
        },

        created() {
            EventBus.$on('save:setting', function (data) {
                console.log('Change data to: \n')
                console.log(data)
                this.$refs.list.laravelData.data[this.settingId].pivot = data
            })
        }
    }
</script>