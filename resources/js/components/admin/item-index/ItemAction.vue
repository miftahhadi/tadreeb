<template>
    <div class="btn-list flex-nowrap">
                <a :href="itemUrl" class="btn btn-sm btn-primary">Buka</a>

                <a :href="editUrl" class="btn btn-sm btn-light">Edit</a>

                <button class="btn btn-danger btn-sm">Hapus</button>
                    
            </div>
</template>

<script>
export default {
    name: 'item-action',

    props: {
        itemName: String,
        itemSlug: String,
    },

    computed: {
        itemUrl() {
            return '/admin/' + this.itemName + '/' + this.itemSlug;
        },
        editUrl() {
            return '/admin/' + this.itemName + '/' + this.itemSlug + '/edit';
        }
    }
}
</script>