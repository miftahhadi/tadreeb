<template>
    <form>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group input-group-flat">
                <input :type="passwordType" class="form-control" v-model="password" autocomplete="off">
                <span class="input-group-text">
                    <a href="#" class="input-group-link" @click="togglePassword()">Lihat</a>
                </span>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Ulangi Password</label>
            <div class="input-group input-group-flat">
                <input :type="confirmPasswordType" class="form-control" v-model="confirmPassword" autocomplete="off">
                <span class="input-group-text">
                    <a href="#" class="input-group-link" @click="toggleConfirmPassword()">Lihat</a>
                </span>
            </div>
        </div>

        <slot name="cancelBtn">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </slot>
        <button class="btn btn-success" :class="[confirmed, submitting]" @click.prevent="submit">Simpan</button>
    </form>
</template>

<script>
import swal from 'sweetalert';

export default {
    name: 'password-change-form',

    props: {
        userId: {
            required: true
        }
    },

    data() {
        return {
            password: null,
            confirmPassword: null,
            showPasswordType: false,
            showConfirmPasswordType: false,

            loading: false
        }
    },

    methods: {
        togglePassword() {
            this.showPasswordType = !this.showPasswordType;
        },

        toggleConfirmPassword() {
            this.showConfirmPasswordType = !this.showConfirmPasswordType;
        },

        submit() {
            this.loading = true;

            axios.put('/api/user/' + this.userId + '/password', {
                newPassword: this.password
            }).then(response => {
                swal({
                    title: "Password berhasil diubah",
                    icon: "success",
                });

                this.loading = false
                this.password = null
                this.confirmPassword = null
            })
        }
    },

    computed: {
        confirmed() {
            return (this.password == null | this.password == '' |
                    this.password != this.confirmPassword) ? 'disabled' : '';
        },

        passwordType() {
            return (this.showPasswordType) ? 'text' : 'password';
        },

        confirmPasswordType() {
            return (this.showConfirmPasswordType) ? 'text' : 'password';
        },

        submitting() {
            return (this.loading == true) ? 'btn-loading' : '';
        }

    }
}
</script>