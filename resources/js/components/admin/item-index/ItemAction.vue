<template>
    <div>
        <div class="btn-list flex-nowrap">
                <a :href="showUrl" class="btn btn-sm btn-primary">Buka</a>

                <a :href="editUrl" class="btn btn-sm btn-light">Edit</a>

                <button v-if="assignPage" 
                        class="btn btn-danger btn-sm"
                >Keluarkan</button>

                <button v-else
                        class="btn btn-danger btn-sm" 
                        data-toggle="modal" 
                        data-target="#deleteItemModal"
                        @click="deleteItem"
                >Hapus</button>
                    
        </div>
    </div>

</template>

<script>
export default {
    name: 'item-action',

    props: {
        itemType: String,
        itemSlug: String,
        itemId: Number,
        assignPage: Boolean,
        itemUrl: String,
    },

    data() {
        return {
            url: this.itemUrl ?? '/admin/' + this.itemType + '/',
        }
    },

    computed: {
        selector() {
            return this.itemSlug ?? this.itemId;
        },

        showUrl() {
            return this.url + this.selector;
        },

        editUrl() {
            return this.url + this.selector + '/edit';
        },

        assignText() {
            return 'Masukkan';
        }
    },

    methods: {
        deleteItem() {
            this.$emit('delete:item', this.itemId);
        }
    }
}
</script>