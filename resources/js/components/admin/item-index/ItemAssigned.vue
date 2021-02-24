<template>
    <div>
        <item-list
            :item="item"
            :table-heading="itemData.heading"
            :item-properties="itemData.props"
            :fetch-url="itemData.fetchUrl"
        >

            <template v-slot:action="actionProp">
                <div class="btn-list flex-nowrap">

                    <button 
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
    </div>
</template>

<script>
export default {
    name: 'item-assigned',

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
            EventBus.$emit('callSetting', {
                item: this.item,
                id: id
            })
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