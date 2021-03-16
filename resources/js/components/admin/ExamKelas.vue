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
    import  { examSetting } from '../../mixins/ExamSetting';

    export default {
        name: 'exam-kelas',

        mixins: [examSetting],

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
            
        },

    }
</script>