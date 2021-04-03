<template>
    <div>
        <slot name="header"></slot>

        <item-list 
            :fetchUrl="fetchUrl"
            :tableHeading="tableHeading" 
            :itemProperties="itemProperties" 
            :action="true"
            :search="true"
            ref="list"
        >
            <template v-slot:top-right>
                <div class="btn-list">
                    <button 
                        type="button" 
                        class="btn" 
                        data-toggle="modal" 
                        data-target="#edit"
                        v-if="item != 'soal'"
                    >

                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </span>
                        <span>{{ title }} Baru</span>
                    
                    </button>

                    <a href="/admin/soal/create" class="btn" v-else>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </span>

                        <span>{{ title }} Baru</span>
                    </a>

                    <a href="/admin/user/import-csv" class="btn btn-success" v-if="item == 'user'">Impor dari .CSV</a>

                </div>
            </template>

            <template v-slot:action="actionProps">
                <div class="btn-list flex-nowrap">
                    <a :href="openUrl(actionProps.item)" class="btn btn-sm" v-text="(item == 'user') ? 'Lihat Profil' : 'Buka'" v-if="item != 'soal'">Lihat Profil</a>

                    <button v-else
                        class="btn btn-light btn-sm"
                        data-toggle="modal"
                        data-target="#viewQuestionModal"
                        @click="callView(actionProps.item)"
                    >Lihat</button>

                    <a :href="editUrl(actionProps.item)" class="btn btn-sm">Edit</a>
                    
                    <button 
                        class="btn btn-sm btn-danger" 
                        data-toggle="modal" 
                        data-target="#deleteItemModal" 
                        @click="callDelete(actionProps.item)"
                        v-if="!cantBeDeleted(actionProps.item)"
                    >Hapus</button>
                </div>
            </template>
        </item-list>
        
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
                    @saved="$refs.list.getResults()"
                    @savedAndGo="goToItem($event)"
                    :user-id="itemId"
                    ref="edit"
                >
                </user-edit-form>
                <item-edit-form v-else
                    :user-id="userId" 
                    :parent-id="parentId"
                    :item-id="itemId"
                    :item="item" 
                    :slug-name="slugName" 
                    :store-url="store"
                    @saved="$refs.list.getResults()"
                    @savedAndGo="goToItem($event)"
                    ref="edit"
                ></item-edit-form>
            </template>
            <template #footer></template>
        </modal>

        <question-viewer
            ref="viewQuestionModal"
            v-if="item == 'soal'"    
        ></question-viewer>

    </div>    
</template>

<script>
    import swal from "sweetalert";

    export default {
        name: 'item-index',

        props: {
            userId: Number,
            parentId: Number,
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
            baseUrl: String,
            itemIdentifier: String,
            nameShownAs: String,
            storeUrl: String,
            deleteUrl: String
        },
        
        data() {
            return {
                loading: false,
                base: this.baseUrl ?? '/admin/' + this.item + '/',
                identifier: (this.itemIdentifier != '') ? this.itemIdentifier : 'id',
                itemName: (this.nameShownAs != '') ? this.nameShownAs : 'nama',
                itemToDelete: {},
                itemId: null,
                store: this.storeUrl ?? '/api/' + this.item,
            }
        },

        methods: {
            deleteItem() {
                const url = (this.deleteUrl) ? this.deleteUrl + '/' + this.itemToDelete[this.identifier] 
                                             : '/api/' + this.item + '/' + this.itemToDelete[this.identifier]

                axios.delete(url)
                        .then(response => {
                            this.$refs.list.getResults();
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
            },

            cantBeDeleted(data) {
                if (this.item == 'user') {
                    return (data.role == 'admin' || data.role == 'superadmin')
                }
            },

            callView(item) {
                this.$refs.viewQuestionModal.toView = item
            }
        },

        computed: {
            slugName() {
                return (this.item != 'grup' && this.item != 'kelas') ? 'Slug' : null
            },

            title() {
                return this.item.charAt(0).toUpperCase() + this.item.slice(1);
            },
        }
    }
</script>