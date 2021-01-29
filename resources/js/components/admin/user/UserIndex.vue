<template>
    <div>
        <div class="page-header">
            <div class="row align-items-center mw-100">

                <div class="col">
                    <div class="mb-1">
                        <ol class="breadcrumb breadcrumb-arrows breadcrumb-alternate" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">
                                Daftar User
                            </a></li>
                        </ol>
                    </div>
                    <h1>
                        <span class="text-truncate">Daftar User</span>
                    </h1>
                </div>

                <div class="col-auto">
                    <div class="btn-list">
                        <button type="button" class="btn" 
                                data-toggle="modal" data-target="#tambahBaru"
                        >
    
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            </span>
                            <span>Tambah Baru</span>
                        
                        </button>

                        <a href="#" class="btn btn-success">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 13v-8a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5.5m-9.5 -2h7m-3 -3l3 3l-3 3" /></svg>
                            </span>
                            <span>Impor dari .CSV</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 mb-1">

            <div class="col-auto" v-if="search">

                <div class="input-icon">
                    <input type="text" class="form-control form-control-rounded" 
                        placeholder="Cari..." v-model="query"
                        @input="getResults"
                    >

                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
                    </span>
                    
                </div>

            </div>
            

            <div class="col-auto ml-auto">
                <pagination :data="laravelData"
                    :limit="1" :show-disabled="true"
                    @pagination-change-page="getResults"
                ></pagination>
            </div>
            
        </div>

        <div class="box mt-3">

            <div class="card">
                <div class="dimmer" :class="isLoading">
                    <div class="loader"></div>

                    <div class="dimmer-content">

                        <v-table :headings="tableHeading" :properties="itemProperties" :data="laravelData.data" :action="true">
                            <template v-slot:action="actionProps">
                                <div class="btn-list flex-nowrap">
                                    <a href="#" class="btn btn-sm" v-if="item == 'user'">Lihat</a>

                                    <a :href="openUrl(actionProps.item)" class="btn btn-sm" v-else>Buka</a>

                                    <a :href="editUrl(actionProps.item)" class="btn btn-sm">Edit</a>
                                    
                                    <button class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deleteItemModal" @click="callDelete(actionProps.item)">Hapus</button>
                                </div>
                            </template>
                        </v-table>

                    </div>
                </div>
            </div>

        </div>

        
        <modal id="tambahBaru" :classes="['modal-dialog-centered']">

            <template #title>Tambah User Baru</template>

            <template #body>

            </template>

            <template #footer>
                <div class="btn-list mt-4">
                    <a href="#" class="btn btn-white">Batal</a>
                    <input type="submit" name="submit" value="Simpan" class="btn btn-success">
                </div>
            </template>

        </modal>

    </div>
</template>

<script>
export default {
    name: 'user-index',

    props: {
        item: {
            type: String,
            default: 'user'
        },
        tableHeading: {
            type: Array,
            required: true
        },
        itemProperties: {
            type: Array,
            required: true
        },
        fetchUrl: {
            type: String,
            required: true
        },
        search: Boolean,
        baseUrl: String,
        itemIdentifier: String,
        nameShownAs: String,
        deleteUrl: String
    },
    data() {
        return {
            laravelData: {},
            loading: false,
            query: '',
            base: this.baseUrl ?? '/admin/' + this.item + '/',
            identifier: (this.itemIdentifier != '') ? this.itemIdentifier : 'id',
            itemName: (this.nameShownAs != '') ? this.nameShownAs : 'nama',
            itemToDelete: {}
        }
    },

    watch: {
        // whenever query changes, run this function
        query: function(newQuery, oldQuery) {
            this.debouncedGetResults()
        },
    },

    methods: {
        getResults(page = 1) {
            this.loading = true;
            axios.get(this.uri + page)
                    .then(response => {
                        this.loading = false;
                        this.laravelData = response.data;
                    })
                    .catch(reponse => {
                        this.loading = false;
                    });
        },

        deleteItem() {
            const url = (this.deleteUrl) ? this.deleteUrl + this.itemToDelete[this.identifier] 
                                            : '/api/' + this.item + '/' + this.itemToDelete[this.identifier]

            axios.delete(url)
                    .then(response => {
                        this.getResults();
                        swal({
                            title: "Data berhasil dihapus",
                            icon: "success",
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    })
        },

        openUrl(data) {
            return this.base + data[this.identifier]
        },

        editUrl(data) {
            const edit =this.base + data[this.identifier]
            return edit + '/edit' 
        },

        callDelete(data) {
            this.itemToDelete = data;
        }
    },

    created() {
        this.debouncedGetResults = _.debounce(this.getResults, 500)
    },

    mounted() {
        this.getResults();
    },

    computed: {
        uri() {
            return (this.query == '') ? 
                        this.fetchUrl + '?page=' 
                        : this.fetchUrl + '/search/' + this.query + '?page=';
        },

        isLoading() {
            return (this.loading) ? 'active' : ''
        }
    }

}
</script>