<template>
    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title"><b>Apakah Anda yakin?</b></div>
                </div>
                <div class="modal-body">
                    <div>Anda akan menghapus <strong>{{ title }}</strong></div>
                </div>
                <div class="modal-footer">
                    <form>
                        <div class="btn-list">
                            <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Batal</button>
                            <button type="button" 
                                    class="btn btn-danger" 
                                    data-dismiss="modal"
                                    @click.prevent="deleteItem"
                            >Ya, hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'item-delete-modal',

    props: {
        itemType: String,
        itemToDelete: Object,
    },

    computed: {
        title() {
            return this.itemToDelete.judul ?? this.itemToDelete.nama;
        },

        uri() {
            return '/api/' + this.itemType + '/' + this.itemToDelete.slug;
        }
    },

    methods: {
        deleteItem() {
            axios.delete(this.uri)
                .then(response => {
                    this.$emit('deleted');
                });
        }
    }

}
</script>