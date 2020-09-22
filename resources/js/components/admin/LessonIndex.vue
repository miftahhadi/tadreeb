<template>
    <div>
        <lesson-list
            :lessons="data.data"
        ></lesson-list>
        
        <pagination
            :current-page="data.current_page"
            :last-page="data.last_page"
            :first-page-url="data.first_page_url"
            :last-page-url="data.last_page_url"
            :prev-page-url="data.prev_page_url"
            :next-page-url="data.next_page_url"
        ></pagination>
    </div>    
</template>

<script>
    export default {
        name: 'lesson-index',
        
        data() {
            return {
                uri: '/admin/pelajaran/list',
                data: {},
            }
        },

        methods: {
            getLessons() {
                axios.get(this.uri)
                        .then((response) => {
                            this.data = response.data.lessons;
                        });
            }
        },

        mounted() {
            this.getLessons();
        },
    }
</script>