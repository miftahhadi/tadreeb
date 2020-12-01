<template>
    <div>
        <div class="btn-list flex-nowrap">

            <template v-if="kelasId">

                <a href="#" 
                    class="btn btn-sm btn-ghost-primary"
                    v-if="itemType != 'user'"
                >
                    Pengaturan
                </a>

                <a href="#" 
                    class="btn btn-sm btn-ghost-primary"
                    v-if="itemType == 'ujian'"
                >
                    Lihat Hasil
                </a>

                <a href="" class="btn btn-sm btn-ghost-danger">
                    Keluarkan
                </a>    

            </template>

            <template v-else>

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

            </template>                
                    
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
        kelasId: Number
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