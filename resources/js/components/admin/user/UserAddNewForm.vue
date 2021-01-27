<template>
    <div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Nama</label>
            <div class="col">
                <input type="text" 
                        class="form-control" 
                        placeholder="Masukkan nama user" 
                        name="user[nama]" 
                        v-model="input.nama"
                        @input="validate('nama')"
                >

                <!-- @error('nama') -->
                    <small class="text-danger" v-show="error.nama">{{ error.nama }}</small>
                <!-- @enderror   -->

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Email</label>
            <div class="col">
                <input type="email" class="form-control" placeholder="Masukkan email" name="user[email]" v-model="input.email">

                <!-- @error('email') -->
                    <small class="text-danger" v-show="error.email">{{ error.email }}</small>
                <!-- @enderror   -->

            </div>
        </div>


        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Username</label>
            <div class="col">
                <input type="text" 
                        class="form-control" 
                        placeholder="Masukkan username" 
                        name="user[username]" 
                        autocomplete="off"
                        v-model="input.username"
                >

                <small class="text-danger" v-show="error.username">{{ error.username }}</small>

            </div>
        </div>
        
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Password</label>
            <div class="col">
                <input type="password" 
                        class="form-control" 
                        placeholder="Password" 
                        name="user[password]" 
                        v-model="input.password"
                        @input="validate('password')"
                >

                <!-- @error('password') -->
                     <small class="text-danger" v-show="error.password" @input="validate('password')">{{ error.password}}</small>
                <!-- @enderror   -->

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Peran</label>
            <div class="col">
                <div>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role[name]" value="2" v-model="input.peran">
                        <span class="form-check-label">Administrator</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role[name]" value="3" v-model="input.peran">
                        <span class="form-check-label">Teacher</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role[name]" value="4" v-model="input.peran">
                        <span class="form-check-label">Peserta</span>
                    </label>
                </div>

                <!-- @error('role') -->
                    <small class="text-danger" v-show="error.peran" @change="validate('peran')">{{ error.peran }}</small>
                <!-- @enderror   -->
                    
            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label">Jenis Kelamin</label>

            <div class="col">
        
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="profile[gender]" value="1" v-model="input.gender">
                    <span class="form-check-label">Laki-laki</span>
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="profile[gender]" value="2" v-model="input.gender">
                    <span class="form-check-label">Perempuan</span>
                </label>
                    
            </div>
        </div>
        
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label">Tanggal Lahir</label>
            <div class="col">
                <input type="date" class="form-control" name="profile[tanggal_lahir]" id="tanggal_lahir" v-model="input.tanggal_lahir">

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Nomor WhatsApp</label>
            <div class="col">
                <input type="text" class="form-control" placeholder="Nomor WhatsApp aktif" name="profile[whatsapp]" v-model="input.whatsapp">

                <small class="text-danger" v-show="error.whatsapp">{{ error.whatsapp }}</small>

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Telegram</label>
            <div class="col">
                <input type="text" class="form-control" placeholder="Nomor atau akun telegram" name="profile[telegram]" v-model="input.telegram">

                <small class="text-danger" v-show="error.telegram">{{ error.telegram }}</small>

            </div>
        </div>

        <div class="row d-flex align-items-center">
            <div class="col-auto btn-list">
                <button class="btn btn-white" data-dismiss="modal" aria-label="Close">
                    Batal
                </button>

                <button class="btn btn-success" :class="canSubmit" @click="save">
                    Simpan 
                    <span class="spinner-border spinner-border-sm ml-2" role="status" v-if="saving"></span>
                </button>                   
            </div>
            <div class="col d-flex align-items-center">
                <span class="text-success" v-if="saved">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    Item berhasil disimpan
                </span>  
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    name: 'user-add-new-form',

    data() {
        return {
            input: {
                nama: null,
                username: null,
                email: null,
                password: null,
                peran: "4",
                gender: null,
                tanggal_lahir: null,
                whatsapp: null,
                telegram: null
            },
            error: {
                nama: null,
                username: null,
                email: null,
                password: null,
                peran: null
            },
            saving: false,
            saved: false
        }
    },

    watch: {
        'input.username': function(newUsername, oldUsername) {
            this.validate('username')
        },

        'input.email': function(newEmail, oldEmail) {
            this.validate('email')
        }
    },

    created() {
        this.debouncedCheckData = _.debounce(this.checkData, 500)
    },

    methods: {
        validate($type) {
            this.error[$type] = null;

            if (this.input[$type] == '') {
                this.error[$type] = this.capitalize($type) + ' tidak boleh kosong'
            } else {
                if ($type == 'username' || $type == 'email') {
                    this.debouncedCheckData($type)
                }
            }
        },

        checkData($type) {
            if (this.input[$type] != '') {
                const checkUri = '/api/user/check-data?type=' + $type + '&data=' + this.input[$type];
            
                axios.get(checkUri)
                    .then(response => {
                        if (response.data == 1) {
                            this.error[$type] = this.capitalize($type) + ' ini sudah terpakai, coba yang lain.'
                        } 
                    })   
            }
        },

        capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1)
        },

        save() {
            axios.post('/api/user', {
                data: this.input
            }).then(response => {
                console.log(response.data)
            })
        }
    },

    computed: {
        canSubmit() {
            return (this.validated == true) ? '' : 'disabled'
        },

        validated() {
            // Cek apakah input masih ada yang kosong
            const keys = Object.keys(this.error)
            let emptyData = 0;

            for (let key of keys) {
                emptyData += (this.input[key] == null) ? 1 : 0;
            }
            console.log('emptyData: ' + emptyData)

            let errors = 0;
            
            for (let key of keys) {
                errors += (this.error[key] != null) ? 1 : 0;
            }

            return (emptyData == 0 && errors == 0) ? true : false
        }
    }
}
</script>