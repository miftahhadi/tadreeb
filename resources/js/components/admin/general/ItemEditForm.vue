<template>
    <div>
        <slot>
        </slot>
        <div class="row">
            <div class="col">

                <div class="form-group mb-3">
                    <label class="form-label required">Nama</label>
                    <input type="text" class="form-control" 
                        name="judul" :placeholder="judulPlaceholder" v-model="input.judul" 
                        @input="[slugify(), cekJudul()]"
                        :class="judulInvalid"
                    >

                    <small v-if="errors.judul != null" class="text-danger">{{ errors.judul }}</small>
                    
                </div>

                <div class="form-group mb-3" v-if="slugName != null">
                    <label class="form-label required">
                        {{ slugName }} 
                    </label>
                    <div class="row row-sm">
                        <div class="col">
                            <div class="input-group">
                                <input type="text" v-model="input.slug" 
                                    name="slug" class="form-control" 
                                    :class="slugInvalid" @input="cekSpasi()"
                                >
                                <span class="input-icon-addon" v-if="slugLoading">
                                    <div class="spinner-border spinner-border-sm text-muted" role="status"></div>
                                </span>
                            </div>                                
                        </div>
                    </div>

                    <small class="form-hint">Gunakan (-) sebagai pemisah antar kata, bukan spasi.</small>

                    <small v-if="errors.slug != null" class="text-danger">{{ errors.slug }}</small>
                        
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">
                        Deskripsi
                    </label>
                    <textarea class="form-control" name="deskripsi" rows="6" placeholder="Deskripsi..." v-model="input.deskripsi"></textarea>

                </div>
    
            </div>
        </div>

        <label class="form-check">
            <input class="form-check-input" type="checkbox" v-model="stayHere">
            <span class="form-check-label">Tetap di halaman ini setelah menyimpan data</span>
        </label>

        <div class="row d-flex align-items-center">
            <div class="col-auto btn-list">
                <button class="btn btn-white" data-dismiss="modal" aria-label="Close">
                    Batal
                </button>

                <button class="btn btn-success" :class="disableSubmit" @click="save">
                    Simpan 
                    <span class="spinner-border spinner-border-sm ml-2" role="status" v-show="saving"></span>
                </button>                   
            </div>
            <div class="col d-flex align-items-center">
                <span class="text-success" v-show="saved">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    Item berhasil disimpan
                </span>  
            </div>
        </div>

    </div>
</template>

<script>
// TODO:    - input area belum bisa dikasih class is-invalid kalau error
//          - kalau modal ditutup, input belum kereset
import _ from "lodash";

export default {
    name: 'item-edit-form', 
    props: {
        userId: Number,
        item: String,
        itemId: Number,
        storeUrl: String,
        slugName: String
    },

    data() {
        return {
            judulPlaceholder: 'Tuliskan nama ' + this.item,
            input: {
                judul: '',
                slug: '',
                deskripsi: '',
            },
            errors: {
                judul: null,
                slug: null,
            },
            saving: false,
            slugLoading: false,
            storeTo: this.storeUrl ?? '/api/' + this.item,

            stayHere: false,
            saved: false
        }
    },

    watch: {
        // whenever slug changes, run this function
        'input.slug': function(newSlug, oldSlug) {
            this.validateSlug()
        },
    },

    created() {
        this.debouncedCekSlug = _.debounce(this.cekSlug, 1000)
    },

    mounted() {
        if (this.slugName) {
            this.input.slug = 'judul-' + this.item + '-anda'
        }
    },

    methods: {
        slugify() {
            if (this.slugName) {
                this.input.slug = this.input.judul.toLowerCase().trim().replace(/\s/g, '-');                
            }
        },

        cekSpasi() {
            this.input.slug = this.input.slug.trim().replace(/\s/g, '-');
        },

        cekJudul() {
            this.saved = false
            
            if (this.input.judul.length == 0 ) {
                this.errors.judul = 'Judul tidak boleh kosong';
            } else {
                this.errors.judul = null;
            }
        },

        validateSlug() {
            if (this.slugName == null) {
                return
            }

            if (this.input.slug == 0 ) {
                this.errors.slug = 'Slug URL tidak boleh kosong';
            } else {
                this.slugLoading = true

                this.debouncedCekSlug()
            }
        },

        cekSlug() {   
            axios.get('/api/' + this.item + '/slug/' + this.input.slug)
                    .then(response => {
                        console.log(response.data)
                        if (response.data === 1) {
                            this.slugLoading = false
                            this.errors.slug = 'Slug ini sudah terpakai, mohon ganti dengan yang lain'
                        } else {
                            this.slugLoading = false
                            this.errors.slug = null
                        }
                    })
        },

        save() {
            this.saving = true

            axios.post(this.storeTo, {
                data: this.input,
                userId: this.userId
            }).then(response => {
                this.saving = false;
                this.saved = true

                if (this.stayHere) {
                    this.input.judul = '';
                    this.input.slug = 'judul-' + this.item + '-anda';
                    this.input.deskripsi = '';

                    this.$emit('saved')
                } else {
                    this.$emit('savedAndGo', response.data)
                }

            }).catch(errors => {
                console.log(errors)
            })

            setTimeout(this.saved = false, 3000);
        }

    },

    computed: {
        nameShownAs() {
            return (this.item == 'kelas' || this.item == 'grup') ? 'Nama' : 'Judul'
        },

        judulInvalid() {
            if (this.errors.judul != null) {
                return 'is-invalid';
            }
        },

        slugInvalid() {
            return (this.errors.slug != null) ? 'is-invalid' : '';
        },

        disableSubmit() {
            return (this.input.judul.length == 0 || this.errors.judul != null || this.errors.slug != null) ? 'disabled' : '';
        },
    }
}
</script>