<template>
    <div>
        <item-list
            :item="item"
            :tableHeading="tableHeading"
            :item-properties="itemProperties"
            :fetch-url="fetchUrl"
        >

            <template v-slot:action>
                    <button 
                        class="btn btn-sm btn-outline-danger" 
                        data-toggle="modal" 
                        data-target="#deleteItemModal" 
                    >Buang</button>
                </template>

        </item-list>
    </div>
</template>

<script>
export default {
    name: 'item-show',

    props: {
        item: {
            type: String,
            required: true
        },
        tableHeading: {
            type: Array,
            required: true
        },
        itemProperties: {
            type: Array,
            required: true
        },
        fetchUrl: {
            type: String,
            required: true
        }
    },
}
</script>