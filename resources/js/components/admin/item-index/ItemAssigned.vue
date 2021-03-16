<template>
    <div>
        <item-list
            :table-heading="itemData.heading"
            :item-properties="itemData.props"
            :fetch-url="itemData.fetchUrl"
        >

            <template v-slot:action="actionProp">
                <div class="btn-list flex-nowrap">

                    <a href="#" class="btn btn-sm" v-if="item == 'ujian'">Hasil</a>

                    <button v-if="setting"
                        class="btn btn-sm"
                        data-toggle="modal" 
                        :data-target="'#' + setting" 
                        @click="callSetting(actionProp.item.id)"
                    >Pengaturan</button>

                    <button 
                        class="btn btn-sm btn-danger"
                        data-toggle="modal"
                        data-target="#unassignItemModal"
                        @click="callUnassign(actionProp.item)"
                    >Buang</button>

                </div>
            </template>

        </item-list>

        <kelas-item-setting-modal
            item="exam"
            ref="settingModal"
            @save:setting="updateSetting"
        ></kelas-item-setting-modal>

    </div>
</template>

<script>
import { examSetting } from '../../../mixins/ExamSetting'

export default {
    name: 'item-assigned',

    mixins: [examSetting],

    props: {
        item: {
            type: String,
            required: true
        },
        itemData: {
            type: [Array, Object],
            required: true
        },
        kelasId: {
            type: Number,
            required: true
        },
        setting: String
    },

    methods: {
        callSetting(id) {
            // EventBus.$emit('callSetting', {
            //     item: this.item,
            //     id: id
            // })
        },

        callUnassign(data) {
            EventBus.$emit('callUnassign', {
                item: this.item,
                itemData: data
            }) 
        }
    }
}
</script>