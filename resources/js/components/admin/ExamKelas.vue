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
        getSetting(data) {
            this.$refs.settingModal.input = this.$refs.list.laravelData.data[data].pivot
            this.settingId = data
            console.log('Getting data: \n')
            console.log(this.$refs.list.laravelData.data[data].pivot)
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