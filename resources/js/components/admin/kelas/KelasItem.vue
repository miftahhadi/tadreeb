<template>
    <div>

        <div class="row">
            <div class="col">
                <h2>Ujian</h2>
            </div>

            <div class="col-auto ml-auto">
                <button class="btn btn-primary" 
                        data-toggle="modal" 
                        data-target="#assignUjianModal"
                >Tambah Ujian</button>
            </div>
        </div>

        <item-list
            :table-heading="itemData.heading"
            :item-properties="itemData.props"
            :fetch-url="itemData.fetchUrl"
        >

            <template v-slot:action="actionProp">
                <div class="btn-list flex-nowrap">

                    <a href="#" class="btn btn-sm" v-if="item == 'ujian'">Hasil</a>

                    <button v-if="setting"
                        class="btn btn-sm"
                        data-toggle="modal" 
                        :data-target="'#' + setting" 
                        @click="callSetting(actionProp.item.id)"
                    >Pengaturan</button>

                    <button 
                        class="btn btn-sm btn-danger"
                        data-toggle="modal"
                        data-target="#unassignItemModal"
                        @click="callUnassign(actionProp.item)"
                    >Buang</button>

                </div>
            </template>

        </item-list>
    
    </div>
</template>

<script>
export default {
    name: 'kelas-item',

    props: {
        item: String,
        itemData: Object
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