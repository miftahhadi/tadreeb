<template>
    <div>
        <div class="row mb-1">

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

            <div class="dimmer" :class="isLoading">
                <div class="loader"></div>

                <div class="dimmer-content">

                    <div class="card">

                        <v-table 
                            :headings="tableHeading" 
                            :properties="itemProperties" 
                            :item-data="laravelData.data" 
                            :action="true"
                        >
                            <template v-slot:action="slotProp">
                                <slot name="action" :item="slotProp.item">

                                </slot>
                                
                            </template>
                        </v-table>

                        <div class="card-footer d-flex align-items-center" v-if="laravelData.last_page != 1">
                            <pagination class="pagination m-0 ml-auto" :data="laravelData"
                                :limit="1" :show-disabled="true"
                                @pagination-change-page="getResults"
                            ></pagination>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: 'item-list',

    props: {
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
        search: Boolean
    },

    data() {
        return {
            laravelData: {},
            loading: false,
            query: '',
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

    }
}
</script>