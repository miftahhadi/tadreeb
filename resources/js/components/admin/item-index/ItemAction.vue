<template>
    <div class="btn-list flex-nowrap">
                <a :href="showUrl" class="btn btn-sm btn-primary">Buka</a>

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
        parent: String,
        parentId: Number,
    },

    data() {
        return {
            url: ''
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
        }
    },

    methods: {
        setUrl() {
            if (typeof this.parent !== 'undefined') {
                this.url = '/admin/' + this.parent + '/' + this.parentId + '/' + this.itemType + '/'  
            } else {
                this.url = '/admin/' + this.itemType + '/'
            }
                                      
        },

        deleteItem() {
            this.$emit('delete:item', this.itemId);
        }
    },

    mounted() {
        this.setUrl();
    }
}
</script>