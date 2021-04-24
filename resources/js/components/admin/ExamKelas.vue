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
                        @click="callSetting(actionProp.index, actionProp.item)"
                    >Pengaturan</button>
                    
                    <a :href="'/admin/ujian/' + examId + '/hasil?kelas=' + actionProp.item.id " class="btn btn-sm">Hasil</a>
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
            callSetting(index, item) {
                const setting = item.pivot

                EventBus.$emit('setting:get', {
                    kelasId: item.id,
                    examId: this.examId,
                    setting: setting,
                    settingId: index
                })
            },
        },

        created() {
            EventBus.$on('setting:update', (data) => {
                this.$refs.list.laravelData.data[data.settingId].pivot = data.setting
            })
        }

    }
</script>