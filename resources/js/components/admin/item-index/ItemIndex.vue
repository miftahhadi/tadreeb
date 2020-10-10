<template>
    <div>

        <div class="row mb-3">

            <div class="col-auto" v-if="search">

                <div class="input-icon">
                    <input type="text" 
                            class="form-control form-control-rounded" 
                            placeholder="Cari..."
                            v-model="query"
                            @input="getResults"
                    >

                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
                    </span>
                    
                </div>

            </div>
            

            <div class="col-auto ml-auto">
                <pagination
                    :data="laravelData"
                    @pagination-change-page="getResults"
                ></pagination>
            </div>
            
        </div>

        <div class="box">
            <item-list
                :item-type="item"
                :items="laravelData.data"
                :loading="loading"
                :headings="tableHeading"
                :item-properties="itemProperties"
                :parent="parent"
                :parent-id="parentId"
                @delete:item="deleteItem"
            ></item-list>
        </div>
        
        <item-delete-modal
            :item-type="item"
            :item-to-delete="itemToDelete"
            @deleted="getResults"
        ></item-delete-modal>

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
            parent: String,
            parentId: Number,
            fetchUrl: String,
        },
        
        data() {
            return {
                laravelData: {},
                loading: false,
                query: '',
                itemToDelete: {},
            }
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
            }
        },

        mounted() {
            this.getResults();
        },

        computed: {
            uri() {
                return (this.query == '') ? 
                            this.fetchUrl + '?page=' 
                            : this.fetchUrl + '/search/' + this.query + '?page=';
            }
        }
    }
</script>