<template>
    <div>
        <slot name="header"></slot>

        <item-list 
            :headings="tableHeading" 
            :properties="itemProperties" 
            :data="laravelData.data" 
            :action="true"
        >
            <template v-slot:top-right>
                <div class="btn-list">
                    <button 
                        type="button" 
                        class="btn" 
                        data-toggle="modal" 
                        data-target="#edit"
                        @click="$refs.edit.reset()"
                    >

                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </span>
                        <span>Tambah Baru</span>
                    
                    </button>

                        <a href="/admin/user/import-csv" class="btn btn-success" v-if="item == 'user'">Impor dari .CSV</a>

                </div>
            </template>

            <template v-slot:action="actionProps">
                <div class="btn-list flex-nowrap">
                    <a href="#" class="btn btn-sm" v-if="item == 'user'">Lihat Profil</a>

                    <a :href="openUrl(actionProps.item)" class="btn btn-sm" v-else>Buka</a>

                    <button 
                        class="btn btn-sm"                                     
                        data-toggle="modal" 
                        data-target="#edit"
                        @click="callEdit(actionProps.item)"
                    >Edit</button>
                    
                    <button class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deleteItemModal" @click="callDelete(actionProps.item)">Hapus</button>
                </div>
            </template>
        </item-list>

        <div class="row mt-4 mb-1">

            <div class="col-auto" v-if="search">

                <div class="input-icon">
                    <input type="text" class="form-control form-control-rounded" 
                        placeholder="Cari..." v-model="query"
                    >

                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
                    </span>
                    
                </div>

            </div>
            

            <div class="col-auto ml-auto">
                <slot name="top-right"></slot>

                
            </div>
            
        </div>

        <div class="box mt-3">

            <div class="card">
                <div class="dimmer" :class="isLoading">
                    <div class="loader"></div>

                    <div class="dimmer-content">

                        <v-table :headings="tableHeading" :properties="itemProperties" :data="laravelData.data" :action="true">
                            <template v-slot:action="actionProps">
                                <slot name="action">

                                </slot>
                                
                            </template>
                        </v-table>

                    </div>
                </div>

                <div class="card-footer d-flex align-items-center" v-if="laravelData.last_page != 1">
                    <pagination class="pagination m-0 ml-auto" :data="laravelData"
                        :limit="1" :show-disabled="true"
                        @pagination-change-page="getResults"
                    ></pagination>
                </div>

            </div>

        </div>
        
        <modal id="deleteItemModal" :classes="['modal-dialog-centered']">
            <template #title>Apakah Anda yakin?</template>
            <template #body>
                <p>Anda akan menghapus {{ itemToDelete[itemName] }}, semua data terkait {{ item }} ini akan terhapus. Apakah Anda yakin?</p>
            </template>
            <template #footer>
                <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Batal</button>
                
                <button 
                    type="button" 
                    class="btn btn-danger" 
                    data-dismiss="modal"
                    @click="deleteItem"
                >Ya, hapus</button>
            </template>
        </modal>
        
        <modal id="edit" :classes="['modal-dialog-centered']">
            <template #title>Tambah {{ item }} Baru</template>
            <template #body>
                <user-edit-form 
                    v-if="item == 'user'"
                    @saved="getResults()"
                    @savedAndGo="goToItem($event)"
                    :user-id="itemId"
                    ref="edit"
                >
                </user-edit-form>
                <item-edit-form v-else
                    :user-id="userId" 
                    :item-id="itemId"
                    :item="item" 
                    :slug-name="slugName" 
                    :store-url="store"
                    @saved="getResults()"
                    @savedAndGo="goToItem($event)"
                    ref="edit"
                ></item-edit-form>
            </template>
            <template #footer></template>
        </modal>

    </div>    
</template>

<script>
    import swal from "sweetalert";

    export default {
        name: 'item-index',

        props: {
            userId: Number,
            item: {
                type: String,
                required: true
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
            storeUrl: String,
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
                itemToDelete: {},
                itemId: null,
                store: this.storeUrl ?? '/api/' + this.item,
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
            },

            callEdit(item) {
                this.$refs.edit.reset()
                this.$refs.edit.id = item.id
            },

            goToItem(data) {
                window.location.href = this.base + data[this.identifier]
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
            },

            slugName() {
                return (this.item != 'grup' && this.item != 'kelas') ? 'Slug' : null
            }
        }
    }
</script>