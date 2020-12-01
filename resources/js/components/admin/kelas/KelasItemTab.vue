<template>
    <div>

        <div class="row">
            <div class="col">
                <h2>{{ title }}</h2>
            </div>

            <div class="col-auto ml-auto">
                <button class="btn btn-primary" 
                        data-toggle="modal" 
                        :data-target="'#assign' + item + 'Modal'"
                >Tambah {{ title }}</button>
            </div>
        </div>

        <div class="">
            <item-index
                :item="item"
                :fetch-url="fetchData"
                :table-heading="headings"
                :item-properties="itemProperties"
                :assignPage="true"
                :key="indexKey"
                :kelas-id="kelasId"
            ></item-index>
        </div>

        <kelas-assign-modal
            :item="item"
            :kelas="kelas"
            :headings="headings"
            :fetch-url="fetchItemUrl"
            :item-properties="itemProperties"
            :assign-url="assignUrl"
            :assigned="assigned"
            @saved="refreshIndex"
        ></kelas-assign-modal>
    
    </div>
</template>

<script>
export default {
    name: 'kelas-item-tab',

    props: {
        item: String,
        kelas: String,
        kelasId: Number,
        headings: Array,
        itemProperties: Array,
        fetchData: String,
        assigned: Array,
    },

    data() {
        return {
            assignUrl: this.fetchData + '/assign',
            fetchItemUrl: '/api/' + this.item,
            indexKey: 0,
        }
    },

    computed: {
        title() {
            if (this.item == 'user') {
                return 'Anggota';
            } else {
                return this.item.charAt(0).toUpperCase() + this.item.slice(1);
            }
        }
    },

    methods: {
        refreshIndex() {
            this.indexKey += 1;
        }
    }
}
</script>