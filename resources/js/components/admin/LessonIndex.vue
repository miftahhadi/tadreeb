<template>
    <div>
        <lesson-list
            :lessons="laravelData.data"
            :loading="loading"
        ></lesson-list>
        
        <pagination
            :data="laravelData"
            @pagination-change-page="getResults"
        ></pagination>
    </div>    
</template>

<script>
    export default {
        name: 'lesson-index',

        props: {
            item: String,
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
                            this.laravelData = response.data;
                            this.loading = false;
                        });
            },
            /* getLessons() {
                this.loading = true,
                axios.get(this.uri)
                        .then((response) => {
                            this.data = response.data.lessons;
                            this.loading = false;
                        });
            }, */

            loadPage(n) {
                this.uri = this.uri + '?page=' + n;
                this.getLessons();
            }
        },

        mounted() {
            this.getResults();
        },
    }
</script>