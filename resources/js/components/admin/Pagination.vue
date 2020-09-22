<template>
    <div>
        <ul class="pagination">
              <li class="page-item" :class="prevPageButton">
                <a class="page-link" href="#" tabindex="-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><polyline points="15 6 9 12 15 18"></polyline></svg>
                </a>
              </li>

              <li class="page-item" v-for="n in range(lastPage)" :key="n" :class="isCurrent(n) ? 'active' : ''">
                  <a class="page-link" href="#">{{ n }}</a>
              </li>

<!--               
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item active"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li> -->
              <li class="page-item">
                <a class="page-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><polyline points="9 6 15 12 9 18"></polyline></svg>
                </a>
              </li>
            </ul>
    </div>
</template>

<script>
export default {
    name: 'pagination',

    props: {
        currentPage: Number,
        lastPage: Number,
        firstPageUrl: String,
        lastPageUrl: String,
        prevPageUrl: String,
        nextPageUrl: String 
    },

    data() {
        return {

        }
    },

    computed: {
        prevPageButton() {
            return this.prevPageUrl ? '' : 'disabled';
        },

        isCurrent(page) {
          return this.currentPage === page;
        }
    }
}
</script>