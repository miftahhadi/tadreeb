<template>
    <div>
        
        <div class="card">

            <div class="card-body">
                <p class="mb-1">Periksa data yang akan diimpor apakah sudah sesuai dengan urutan yang ada di sistem</p>
                
                <div class="table-responsive">
                    <table class="table table-vcenter">

                        <thead>

                            <th v-for="field in fields" :key="field.id">{{ field }}</th>

                        </thead>

                        <tbody>

                            <tr v-for="row in dataToShow" :key="row.id">

                                <td v-for="value in row" :key="value">{{ value }}</td>

                            </tr>

                        </tbody>
                    </table>    
                </div>
            
            </div>
        </div>

        <div class="btn-list">

            <a href="/admin/user" class="btn btn-secondary mr-1">Batal</a>

            <button type="button" 
                    class="btn btn-success" 
                    data-toggle="modal" 
                    data-target="#proses"
                    @click="submit"
            >
                Simpan
            </button>
            
        </div>
        
        <div class="modal fade" 
                id="proses" 
                data-backdrop="static" 
                data-keyboard="false" 
                tabindex="-1" 
                aria-labelledby="prosesLabel" 
                aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h3 class="modal-title">Memproses...</h3>
                    </div>

                    <div class="modal-body">
                        <div class="dimmer" :class="isLoading">
                            <div class="loader"></div>

                            <div class="dimmer-content" v-if="result.length != 0">
                                <p v-if="result.imported != 0">Berhasil memasukkan {{ result.imported }} user baru</p>

                                <p v-if="result.updated != 0">Berhasil memperbarui {{ result.updated }} user</p>

                                <p v-if="result.errors && result.errors.length != 0">
                                    Terjadi kesalahan berikut:
                                    <ul>
                                        <li v-for="error in result.errors" :key="error"> {{ error }}</li>
                                    </ul>
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <a href="/admin/user" class="btn btn-success">Kembali ke Daftar User</a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'import-user',

        props: {
            id: Number,
            fields: Array,
            dataToShow: Array,
        },

        data() {
            return {
                loading: false,
                result: {},
                error: '',
            }
        },

        methods: {
            submit() {
                this.loading = true;

                axios.post('/admin/user/process-csv', {
                    id: this.id
                })
                .then(response => {
                    this.result = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.error = error;
                })
            }
        },

        computed: {
            isLoading() {
                return this.loading ? 'active' : '';
            }
        }
    }
</script>