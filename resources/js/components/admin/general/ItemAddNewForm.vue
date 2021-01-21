<template>
    <div>
        <form action="#" method="post" >
            <slot>
            </slot>
            <div class="row">
                <div class="col">

                    <div class="form-group mb-3">
                        <label class="form-label required">Nama</label>
                        <input type="text" class="form-control" 
                            name="judul" :placeholder="judulPlaceholder" v-model="input.judul" 
                            @input="[slugify(), cekJudul(), cekSlug()]"
                            :class="judulInvalid"
                        >

                        <small v-if="errors.judul != null" class="text-danger">{{ errors.judul }}</small>
                       
                    </div>

                    <div class="form-group mb-3" v-if="slug">
                        <label class="form-label required">
                            {{ slug }} 
                        </label>
                        <div class="row row-sm">
                            <div class="col">
                                <div class="input-group">
                                    <input type="text" v-model="input.slug" 
                                        name="slug" class="form-control" 
                                        :class="slugInvalid" @input="[cekSlug(), cekSpasi()]"
                                    >
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
                
                <div class="btn-list">
                    <button class="btn btn-white" data-dismiss="modal" aria-label="Close">
                        Batal
                    </button>

                    <input type="submit" value="Simpan" class="btn btn-success" :class="disableSubmit">                     
                </div>

            </div>
        </form>
    </div>
</template>

<script>
// TODO:    - input area belum bisa dikasih class is-invalid kalau error
//          - kalau modal ditutup, input belum kereset
export default {
    name: 'item-add-new-form', 
    props: {
        item: String,
        storeUrl: String,
        slug: String
    },
    data() {
        return {
            judulPlaceholder: 'Tuliskan nama ' + this.item,

            input: {
                judul: '',
                slug: 'judul-' + this.item + '-anda',
                deskripsi: '',
            },
            
            errors: {
                judul: null,
                slug: null,
            },

            help: '<p>Slug akan muncul di alamat URL menuju' + this.item + '. Misalnya, <code>' + this.slug + '/nahwu-dasar-2</code></p>' 
        }
    },
    methods: {
        slugify() {
            this.input.slug = this.input.judul.toLowerCase().trim().replace(/\s/g, '-');
        },

        cekSpasi() {
            this.input.slug = this.input.slug.trim().replace(/\s/g, '-');
        },

        cekJudul() {
            if (this.input.judul.length == 0 ) {
                this.errors.judul = 'Judul tidak boleh kosong';
            } else {
                this.errors.judul = null;
            }
        },

        cekSlug() {
            if (this.input.slug == 0 ) {
                this.errors.slug = 'Slug URL tidak boleh kosong';
            } else {
                axios.get('/api/' + this.item + '/slug/' + this.input.slug)
                        .then(response => {
                            if (response.data === 1) {
                                this.errors.slug = 'Slug ini sudah terpakai, mohon ganti dengan yang lain'
                            } else {
                                this.errors.slug = null
                            }
                        })
            }
        },

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