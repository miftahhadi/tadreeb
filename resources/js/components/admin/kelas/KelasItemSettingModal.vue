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

                <button class="btn btn-success" @click="updateSetting()"> 
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
import { DateTime } from "luxon";

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

            settingId: null,
            examId: null,
            kelasId: null,

            dt: ['buka_otomatis', 'tampil_otomatis', 'batas_buka']

        }
    },

    methods: {
        getSetting(data) {
            this.kelasId = data.kelasId
            this.examId = data.examId
            this.settingId = data.settingId

            const setting = data.setting

            for (let key in this.input) {
                if (this.dt.includes(key) && setting[key] != null) {
                    const datetime = DateTime.fromISO(setting[key]).setZone('UTC+7')
                    
                    this.input[key] = {
                        tanggal: datetime.toFormat('yyyy-LL-dd'),
                        waktu: datetime.toFormat('HH:mm')
                    }
                } else if (this.dt.includes(key) && setting[key] == null) {
                    this.input[key] = {
                        tanggal: null,
                        waktu: '00:00'
                    }
                } else {
                    this.input[key] = setting[key]
                }
            }
        },

        updateSetting() {
            const data = {}

            for (let key in this.input) {
                if (this.dt.includes(key) && this.input[key].tanggal != '') {
                    const datetime = DateTime.fromISO(this.input[key].tanggal + 'T' + this.input[key].waktu, {zone: 'UTC+7'})
                    const newdt = datetime.setZone('utc')

                    data[key] = newdt.toISO()
                } else if (this.dt.includes(key) && this.input[key].tanggal == '') {
                    data[key] = null
                } else {
                    data[key] = this.input[key]
                }
            }

            EventBus.$emit('setting:update', {
                settingId: this.settingId,
                setting: data
            })

            axios.post('/api/ujian/setting', {
                examId: this.examId,
                kelasId: this.kelasId,
                setting: data
            }).then(response => {
                swal({
                    title: "Data berhasil disimpan",
                    icon: "success",
                });

                EventBus.$emit('setting:update', {
                    settingId: this.settingId,
                    setting: response.data
                })
            }).catch(error => {
                console.log(error)
            })
        },

    },

    computed: {
        title() {
            return this.item.charAt(0).toUpperCase() + this.item.slice(1);
        }
    },
    
    created() {
        EventBus.$on('setting:get', (data) => {
            this.getSetting(data)
        })
    }
}
</script>