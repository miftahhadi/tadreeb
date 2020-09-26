<template>
    <div class="btn-list flex-nowrap">
                <a :href="itemUrl" class="btn btn-sm btn-primary">Buka</a>

                <a :href="editUrl" class="btn btn-sm btn-light">Edit</a>

                <button class="btn btn-danger btn-sm" 
                        data-toggle="modal" 
                        data-target="#deleteItemModal"
                        @click="deleteItem"
                >Hapus</button>
                    
            </div>
</template>

<script>
export default {
    name: 'item-action',

    props: {
        itemType: String,
        itemSlug: String,
        itemId: Number,
    },

    data() {
        return {
            url: '/admin/' + this.itemType + '/',
        }
    },

    computed: {
        selector() {
            return this.itemSlug ?? this.itemId;
        },

        itemUrl() {
            return this.url + this.selector;
        },

        editUrl() {
            return this.url + this.selector + '/edit';
        }
    },

    methods: {
        deleteItem() {
            this.$emit('delete:item', this.itemId);
        }
    }
}
</script>