<template>
    <div class="modal fade" 
        :id="'assign' + item + 'Modal'" 
        tabindex="-1" 
        aria-labelledby="assignModalLabel" 
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form @submit.prevent="massAssign">
                    <div class="modal-header">
                    Tambah {{ title }} ke Kelas {{ kelas }}
                    </div>
                    <div class="modal-body">

                        <div class="row mb-3">

                            <div class="col-auto">

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
                            <div class="card">
                                <div class="dimmer" :class="isLoading">
                                    
                                    <div class="loader"></div>
                                    
                                    <div class="dimmer-content">
                                        <div class="table-responsive">
                                            <table class="table card-table table-vcenter text-nowrap datatable">
                                                <thead>
                                                    <tr>
                                                        <th class="w-1">
                                                            <input class="form-check-input m-0 align-middle" 
                                                                    type="checkbox" 
                                                                    disabled
                                                            >
                                                        </th>
                                                        <th v-for="heading in headings.slice(0,2)" 
                                                            :key="heading.id" 
                                                            :width="heading.width"
                                                        >{{ heading.name }}</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item in laravelData.data" :key="item.id">
                                                        <td>
                                                            <input class="form-check-input m-0 align-middle" 
                                                                    type="checkbox"
                                                                    :value="item.id"
                                                                    v-model="itemId" 
                                                                    :aria-label="'Pilih' + item "
                                                            >
                                                        </td>
                                                        
                                                        <td v-for="$prop in itemProperties.slice(0,2)" :key="$prop">{{ item[$prop] }}</td>
                                                        <td class="text-right">
                                                           <item-assign
                                                                :item-id="item.id"
                                                                :assign-url="assignUrl"
                                                                :assigned="assigned.includes(item.id)"
                                                                @saved="$emit('saved')"
                                                            ></item-assign>
                                                        </td>
                                                    </tr>
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="submit" value="Tambahkan" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
  
  
</template>

<script>
export default {
    name: 'kelas-assign-modal',

    props: {
        item: String,
        kelas: String,
        fetchUrl: String,
        headings: Array,
        itemProperties: Array,
        assignUrl: String,
        assigned: Array,
    },

    data() {
        return {
            laravelData: {},
            loading: false,
            query: '',
            itemId: [],
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

        massAssign() {

        }
    },

    computed: {
        isLoading() {
            return this.loading ? 'active' : '';
        },

        uri() {
            return (this.query == '') 
                ? this.fetchUrl + '?page=' 
                : this.fetchUrl + '/search/' + this.query + '?page=';
        },

        title() {
            if (this.item == 'user') {
                return 'Anggota';
            } else {
                return this.item.charAt(0).toUpperCase() + this.item.slice(1);
            }
        }
    },

    mounted() {
        this.getResults();
    }
}
</script>