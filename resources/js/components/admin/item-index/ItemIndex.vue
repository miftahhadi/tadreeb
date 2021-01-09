<template>
    <div>
        <slot name="header"></slot>

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

        <div class="box">

            <div class="card">
                <div class="dimmer" :class="isLoading">
                    <div class="loader"></div>

                    <div class="dimmer-content">

                        <data-table :headings="tableHeading" :properties="itemProperties" :data="laravelData.data" :action="true">
                            <template v-slot:action="actionProps">
                                <div class="btn-list flex-nowrap">
                                    <a :href="openUrl(actionProps.item)" class="btn btn-sm">Buka</a>
                                    <a :href="editUrl(actionProps.item)" class="btn btn-sm">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deleteItemModal">Hapus</button>
                                </div>
                            </template>
                        </data-table>

                    </div>
                </div>
            </div>

        </div>
        
        <item-delete-modal :item-type="item" :item-to-delete="itemToDelete" @deleted="getResults"></item-delete-modal>

    </div>    
</template>

<script>
    export default {
        name: 'item-index',

        props: {
            item: String,
            tableHeading: Array,
            itemProperties: Array,
            search: Boolean,
            fetchUrl: String,
        },
        
        data() {
            return {
                laravelData: {},
                loading: false,
                query: '',
                url: '/admin/' + this.item + '/',
                itemToDelete: {},
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

            deleteItem(data) {
                this.itemToDelete = data;
            },

            openUrl(data) {
                return (data.slug) ?  this.url + data.slug : this.url + data.id
            },

            editUrl(data) {
                const edit = (data.slug) ? this.url + data.slug : this.url + data.id
                return edit + '/edit' 
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