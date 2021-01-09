<template>
    <div>
        <form 
            :action="action" 
            method="post" 
        >
            <slot>
            </slot>
            <div class="row">
                <div class="col">

                    <div class="form-group mb-3">
                        <label class="form-label required">{{ judul }}</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="judul" 
                            :placeholder="input.judulPlaceholder" 
                            v-model="input.judul" 
                            @input="[slugify(), cekJudul(), cekSlug()]"
                            :class="judulInvalid"
                        >

                        <div v-if="errors.hasOwnProperty('judul')" class="invalid-feedback">{{ errors.judul}}</div>
                       
                    </div>

                    <div class="form-group mb-3" v-if="slug">
                        <label class="form-label required">
                            {{ slug }} 
                        </label>
                        <div class="row row-sm">
                            <div class="col">
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        name="slug" 
                                        class="form-control" 
                                        v-model="input.slug"
                                        @input="cekSlug"
                                        @change="cekSpasi"
                                        :class="slugInvalid"
                                    >
                                </div>                                
                            </div>
                            <!-- <div class="col-auto align-self-center">
                                <span class="form-help" 
                                        data-toggle="popover" 
                                        data-placement="top" 
                                        :data-content="help" 
                                        data-html="true" 
                                        data-original-title="" title=""
                                >?</span>
                            </div> -->
                        </div>

                        <small class="form-hint">Gunakan (-) sebagai pemisah antar kata, bukan spasi.</small>

                        <small v-if="errors.hasOwnProperty('slug')" class="text-danger">{{ errors.slug }}</small>
                            
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Deskripsi
                            <!-- <span class="form-label-description">Maks: 600 karakter</span> -->
                        </label>
                        <textarea class="form-control" name="deskripsi" rows="6" placeholder="Deskripsi..."></textarea>
                    
                        <!-- <div class="invalid-feedback">{{ $message }}</div> -->

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
//          - kalau langsung input slug, spasi gak otomatis jadi '-'
export default {
    name: 'item-baru-form', 
    props: {
        judul: String,
        item: String,
        action: String,
        slug: String
    },
    data() {
        return {
            input: {
                judul: '',
                slug: 'judul-' + this.item + '-anda',
                deskripsi: '',
                judulPlaceholder: 'Tuliskan nama ' + this.item
            },
            
            errors: {},

            help: '<p>Slug akan muncul di alamat URL menuju' + this.item + '. Misalnya, <code>' + this. slug + '/nahwu-dasar-2</code></p>' 
        }
    },
    methods: {
        slugify() {
            this.input.slug = this.input.judul.toLowerCase().trim().replace(/\s/g, '-');
        },

        cekSpasi() {
            this.input.slg = this.input.slug.trim.replace(/\s/g, '-');
        },

        cekJudul() {
            if (this.input.judul == 0 ) {
                this.errors.judul = 'Judul tidak boleh kosong';
            } else {
                this.errors.judul = null;
            }
        },

        cekSlug() {
            if (this.input.slug == 0 ) {
                this.errors.slug = 'Slug URL tidak boleh kosong';
            } else {
                this.errors.slug = null;
            }
        },

    },

    computed: {
        judulInvalid() {
            if (this.errors.hasOwnProperty('judul')) {
                return 'is-invalid';
            }
        },

        slugInvalid() {
            return (this.errors.hasOwnProperty('slug')) ? 'is-invalid' : '';
        },

        disableSubmit() {
            return (this.input.judul.length == 0 || this.input.slug.length == 0) ? 'disabled' : '';
        },
    }
}
</script>