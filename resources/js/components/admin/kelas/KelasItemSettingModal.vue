<template>
    <div>
        <modal :id="id"
            :classes="['modal-lg', 'modal-dialog-centered']"
            :loading="loading"
            ref="modal"
        >
            <template #title>Pengaturan {{ title }}</template>

            <template #body>

                <div class="form-group mb-3 row">
                    <label class="col-5">Tampilkan {{ item }}?</label>
                    <div class="col">
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tampil" value="1" v-model="input.tampil">
                                <span class="form-check-label">Ya</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tampil" value="0" v-model="input.tampil">
                                <span class="form-check-label">Tidak</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-5">Buka akses?</label>
                    <div class="col">
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="buka" value="1" v-model="input.buka">
                                <span class="form-check-label">Buka</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="buka" value="0" v-model="input.buka">
                                <span class="form-check-label">Tutup</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-5">Buka hasil?</label>
                    <div class="col">
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="buka_hasil" value="1" v-model="input.buka_hasil">
                                <span class="form-check-label">Buka</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="buka_hasil" value="0" v-model="input.buka_hasil">
                                <span class="form-check-label">Tutup</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-5">Otomatis tampilkan pada ({{ tzName }})</label>
                    <div class="col">
                        <div class="row">
                            <div class="col-auto">
                                <input type="date" class="form-control" name="tampil_otomatis[tanggal]" value="" v-model="input.tampil_otomatis.tanggal">
                            </div>
                            <div class="col-auto">
                                <input type="time" class="form-control" name="tampil_otomatis[waktu]" value="" v-model="input.tampil_otomatis.waktu">
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-5">Otomatis buka akses pada ({{ tzName }})</label>
                    <div class="col">
                        <div class="row">
                            <div class="col-auto">
                                <input type="date" class="form-control" name="buka_otomatis[tanggal]" value="" v-model="input.buka_otomatis.tanggal">
                            </div>
                            <div class="col-auto">
                                <input type="time" class="form-control" name="buka_otomatis[waktu]" value="" v-model="input.buka_otomatis.waktu">
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-5">Otomatis tutup akses pada ({{ tzName }})</label>
                    <div class="col">
                        <div class="row">
                            <div class="col-auto">
                                <input type="date" class="form-control" name="batas_buka[tanggal]" value="" v-model="input.batas_buka.tanggal">
                            </div>
                            <div class="col-auto">
                                <input type="time" class="form-control" name="batas_buka[waktu]" value="" v-model="input.batas_buka.waktu">
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <div class="col-5">
                        <label>Durasi (menit)</label>
                        <small class="form-hint">Isi dengan 0 jika tidak ingin memberi durasi</small>
                    </div>

                    <div class="col-auto">

                        <input type="number" class="form-control" name="durasi" value="" v-model="input.durasi">
                        
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <div class="col-5">
                        <label>Kesempatan mencoba</label>
                        <small class="form-hint">Isi dengan 0 jika boleh dikerjakan tanpa batas</small>
                    </div>
                    <div class="col-auto">
                        <input type="number" class="form-control" name="attempt" value="" v-model="input.attempt">
                    </div>
                </div>

            </template>

            <template #footer>
                <!-- <p v-if="done" class="text-success">
                    Pengaturan berhasil disimpan
                </p>

                <p v-else-if="error" class="text-success">
                    Terjadi kesalahan
                </p> -->

                <button class="btn btn-success" @click="save"> 
                    <!-- <span v-if="saving"
                            class="spinner-border spinner-border-sm mr-2" 
                            role="status"
                    ></span>

                    <span v-if="done">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    </span> -->
                    Simpan
                </button>
            </template>
        </modal>
    </div>
</template>

<script>
// import "bootstrap";

export default {
    name: 'kelas-item-setting-modal',

    props: {
        item: String,
        loading: Boolean,
        saving: Boolean,
        done: Boolean,
        error: Boolean,
        timezone: String,
    },

    data() {
        return {
            id: this.item + 'Setting'  + 'Modal',
            input: {
                tampil: 0,
                buka: 0,
                buka_hasil: 0,
                tampil_otomatis: {
                    tanggal: null,
                    waktu: '00:00'
                },
                buka_otomatis: {
                    tanggal: null,
                    waktu: '00:00'
                },
                batas_buka: {
                    tanggal: null,
                    waktu: '00:00'
                },
                durasi: 0,
                attempt: 0,
            },

            tzName: (this.timezone) ?? 'WIB',

            modal: null,

        }
    },

    methods: {
        save() {
            return this.$emit('save:setting', {
                data: this.input
            });
        }
    },

    computed: {
        title() {
            return this.item.charAt(0).toUpperCase() + this.item.slice(1);
        }
    },

    mounted() {
        /* this.modal = new bootstrap.Modal(document.getElementById(this.id), {
            keyboard: false,
        }); */
    }
}
</script>