<template>
    <div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Nama</label>
            <div class="col">
                <input type="text" 
                        class="form-control" 
                        placeholder="misal: Ahmad Syukran" 
                        name="user[nama]" 
                        v-model="input.nama"
                        @input="validate('nama')"
                >

                <small class="text-danger" v-show="error.nama">{{ error.nama }}</small>

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Email</label>
            <div class="col">
                <input type="email" class="form-control" placeholder="misal: ahmad.sy@email.com" name="user[email]" v-model="input.email">

                <small class="text-danger" v-show="error.email">{{ error.email }}</small>

            </div>
        </div>


        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Username</label>
            <div class="col">
                <input type="text" 
                        class="form-control" 
                        placeholder="misal: ahmad.syukran, ahmad123, dll" 
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
                        placeholder="misal: 1234qwer" 
                        name="user[password]" 
                        v-model="input.password"
                        @input="validate('password')"
                >

                <small class="text-danger" v-show="error.password" @input="validate('password')">{{ error.password}}</small>

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

                <small class="text-danger" v-show="error.peran" @change="validate('peran')">{{ error.peran }}</small>
                    
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
            <label class="form-label col-3 col-form-label">WhatsApp</label>
            <div class="col">
                <input type="text" class="form-control" placeholder="misal: +6281234567890" name="profile[whatsapp]" v-model="input.whatsapp">

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label">Telegram</label>
            <div class="col">
                <input type="text" class="form-control" placeholder="misal: @user.name" name="profile[telegram]" v-model="input.telegram">

            </div>
        </div>

        <label class="form-check mt-3">
            <input class="form-check-input" type="checkbox" v-model="stayHere">
            <span class="form-check-label">Tetap di halaman ini setelah menyimpan data</span>
        </label>

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
    name: 'user-edit-form',

    data() {
        return {
            id: null,
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
            saved: false,
            stayHere: false,
        }
    },

    watch: {
        'input.username': function(newUsername, oldUsername) {
            this.validate('username')
        },

        'input.email': function(newEmail, oldEmail) {
            this.validate('email')
        },

        id: function(newid, oldid) {
            this.getUser(newid)
        }
    },

    created() {
        this.debouncedCheckData = _.debounce(this.checkData, 500)
    },

    methods: {
        getUser(id) {
            axios.get('/api/user/' + id)
                    .then(response => {
                        this.input.nama = response.data.name
                        this.input.username = response.data.username
                        this.input.email = response.data.email
                        this.input.gender = response.data.profile.gender
                        this.input.tanggal_lahir = response.data.profile.tanggal_lahir
                        this.input.whatsapp = response.data.whatsapp
                        this.input.telegram = response.data.telegram
                        console.log(response.data)
                    })
        },

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
                const checkUri = '/api/user/check-data?type=' + $type + '&data=' + this.input[$type] + '&id=' + this.id;
            
                axios.get(checkUri)
                    .then(response => {
                        if (response.data == 1) {
                            this.error[$type] = this.capitalize($type) + ' ini sudah terpakai, coba yang lain.'
                        } 
                    })   
            }
        },
        
        reset() {
            const inputKeys = Object.keys(this.input)
            const errorKeys = Object.keys(this.error)

            for (let key of inputKeys) {
                this.input[key] == null
            }

            for (let key of errorKeys) {
                this.error[key] == null 
            }
        },

        capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1)
        },

        save() {
            this.saving = true

            axios.post('/api/user', {
                data: this.input
            }).then(response => {
                this.saving = false
                this.saved = true

                if (this.stayHere) {        
                    for (let key in this.input) {
                        this.input[key] = null
                    }

                    this.$emit('saved')
                } else {
                    this.$emit('savedAndGo', response.data)
                }

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

            return (emptyData == 0 && errors == 0)
        }
    }
}
</script>