<template>
    <div>
        <button 
            v-if="!assigned"
            class="btn btn-primary"
            :class="buttonLoading"
            v-text="buttonText"
            @click.prevent="assignItem"
        ></button>
        <div class="text-muted" v-else><i>Item sudah ditambahkan</i></div>
    </div>
</template>

<script>
export default {
    name: 'item-assign',

    props: {
        itemId: Number,
        assignUrl: String,
        assigned: Boolean
    },

    data() {
        return {
            status: this.assigned,
            loading: false,
        }
    },

    methods: {
        assignItem() {
            this.loading = true;
            axios.post(this.assignUrl, {
                    itemId: this.itemId
                })
                .then(response => {
                    this.status = ! this.status;
                    this.loading = false;
                    this.$emit('saved')
                }).
                catch(error => {
                    console.log(error);
                });
        }
    },

    computed: {
        buttonText() {
            return (this.status) ? 'Hapus' : 'Tambahkan';
        },

        buttonColor() {
            return (this.status) ? 'btn-danger' : 'btn-primary';
        },

        buttonLoading() {
            return (this.loading) ? 'btn-loading' : '';
        }
    }
}
</script>

