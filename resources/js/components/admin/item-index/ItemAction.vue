<template>
    <div>
        <div class="btn-list flex-nowrap">
                <a :href="showUrl" class="btn btn-sm btn-ghost-primary">
                    Buka
                </a>

                <a :href="editUrl" class="btn btn-sm btn-ghost-primary">
                    Edit
                </a>

                <button class="btn btn-sm btn-ghost-danger" 
                        data-toggle="modal" 
                        data-target="#deleteItemModal"
                        @click="deleteItem"
                >
                    Hapus
                </button>

                <a href="#" 
                    class="btn btn-sm btn-ghost-primary"
                >
                    Pengaturan
                </a>

                <a href="" class="btn btn-sm btn-ghost-danger">
                    Keluarkan
                </a>
                    
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