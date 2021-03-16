export const examSetting = {
    methods: {
        getSetting(id) {
            const setting = this.$refs.settingModal.input
            const data = this.$refs.list.laravelData.data[id].pivot

            this.settingId = id
            this.kelasId = this.$refs.list.laravelData.data[id].id

            for (let key in setting) {
                if (this.dt.includes(key) && data[key] != null) {
                    const datetime = DateTime.fromISO(data[key]).setZone('UTC+7')
                    
                    this.$refs.settingModal.input[key] = {
                        tanggal: datetime.toFormat('yyyy-LL-dd'),
                        waktu: datetime.toFormat('HH:mm')
                    }
                } else if (this.dt.includes(key) && data[key] == null) {
                    this.$refs.settingModal.input[key] = {
                        tanggal: null,
                        waktu: '00:00'
                    }
                } else {
                    this.$refs.settingModal.input[key] = data[key]
                }
            }
        },

        updateSetting(setting) {
            const data = this.$refs.list.laravelData.data[this.settingId].pivot

            for (let key in setting) {
                if (this.dt.includes(key) && setting[key].tanggal != '') {
                    const datetime = DateTime.fromISO(setting[key].tanggal + 'T' + setting[key].waktu, {zone: 'UTC+7'})
                    const newdt = datetime.setZone('utc')

                    data[key] = newdt.toISO()
                } else if (this.dt.includes(key) && setting[key].tanggal == '') {
                    data[key] = null
                } else {
                    data[key] = setting[key]
                }
            }

            axios.post('/api/ujian/setting', {
                examId: this.examId,
                kelasId: this.kelasId,
                setting: data
            }).then(response => {
                swal({
                    title: "Data berhasil disimpan",
                    icon: "success",
                });
            }).catch(error => {
                console.log(error)
            })
        }
    }
}