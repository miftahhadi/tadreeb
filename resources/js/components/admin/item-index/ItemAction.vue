<template>
    <div>
        <div class="btn-list flex-nowrap">

            <template v-if="kelasId">

                <button
                    class="btn btn-sm btn-ghost-primary"
                    v-if="itemType != 'user'"
                    data-toggle="modal" 
                    :data-target="'#setting' + itemType + 'Modal'"
                    :data-item-id="itemId"
                    @click="openSetting(itemId)"
                >
                    Pengaturan
                </button>

                <a :href="resultUrl" 
                    class="btn btn-sm btn-ghost-primary"
                    v-if="itemType == 'ujian'"
                >
                    Lihat Hasil
                </a>

                <a href="#" class="btn btn-sm btn-ghost-danger">
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
            selector: this.itemSlug ?? this.itemId
        }
    },

    computed: {
        showUrl() {
            return this.url + this.selector;
        },

        editUrl() {
            return this.url + this.selector + '/edit';
        },

        assignText() {
            return 'Masukkan';
        },

        settingUrl() {
            return (this.itemType != 'user') 
                                ? this.url + this.selector + '/setting?kelas=' + this.kelasId
                                : ''
        },

        resultUrl() {
            return (this.itemType == 'ujian')
                                ? this.url + this.selector + '/hasil'
                                : ''
        }
    },

    methods: {
        deleteItem() {
            this.$emit('delete:item', this.itemId);
        },

        openSetting(itemId) {
            this.$parent.$parent.$emit('show:setting', itemId)
        }
    }
}
</script>