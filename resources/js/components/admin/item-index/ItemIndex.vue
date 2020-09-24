<template>
    <div>
        <item-list
            :item-name="item"
            :items="laravelData.data"
            :loading="loading"
            :headings="tableHeading"
            :item-properties="itemProperties"
        ></item-list>
        
        <pagination
            :data="laravelData"
            @pagination-change-page="getResults"
        ></pagination>
    </div>    
</template>

<script>
    export default {
        name: 'item-index',

        props: {
            item: String,
            tableHeading: Array,
            itemProperties: Array
        },
        
        data() {
            return {
                laravelData: {},
                loading: false,
                uri: '/admin/' + this.item + '/list?page=',
            }
        },

        methods: {
            getResults(page = 1) {
                this.loading = true;
                axios.get(this.uri + page)
                        .then(response => {
                            this.loading = false;
                            this.laravelData = response.data;
                        });
            },

        },

        mounted() {
            this.getResults();
        },
    }
</script>