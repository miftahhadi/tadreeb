<template>
    <div>
        <item-list
            :item="item"
            :table-heading="itemData.heading"
            :item-properties="itemData.props"
            :fetch-url="itemData.fetchUrl"
        >

            <template v-slot:action>
                <div class="btn-list flex-nowrap">
                    <button 
                        class="btn btn-sm"
                        data-toggle="modal" 
                        data-target="#examSettingModal" 
                    >Pengaturan</button>
                    <button class="btn btn-sm btn-danger">Buang</button>
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
        }

    }
}
</script>