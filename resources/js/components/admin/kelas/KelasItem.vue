<template>
    <div>

        <div class="row">
            <div class="col">
                <h2>{{ title }}</h2>
            </div>

            <div class="col-auto ml-auto">
                <button class="btn btn-primary" 
                        data-toggle="modal" 
                        :data-target="'#assign' + title + 'Modal'"
                >Tambah {{ title }}</button>
            </div>
        </div>

        <item-list
            :table-heading="itemData.heading"
            :item-properties="itemData.props"
            :fetch-url="itemData.fetchUrl"
            :key="listKey"
            ref="list"
        >

            <template v-slot:action="actionProp">
                <div class="btn-list flex-nowrap">

                    <a :href="'/admin/grup/' + kelas.group_id + '/kelas/' + kelas.id + '?page=hasil_ujian&ujianId=' + actionProp.item.id" class="btn btn-sm" v-if="itemData.item == 'ujian'">Hasil</a>

                    <button v-if="settingModal"
                        class="btn btn-sm"
                        data-toggle="modal" 
                        :data-target="'#' + settingModal" 
                        @click="callSetting(actionProp.index, actionProp.item)"
                    >Pengaturan</button>

                    <button 
                        class="btn btn-sm btn-danger"
                        data-toggle="modal"
                        data-target="#unassignItemModal"
                        @click="callUnassign(actionProp.item)"
                    >Buang</button>

                </div>
            </template>

        </item-list>

        <kelas-assign-modal
            :item="itemData.item"
            :kelas="kelas.nama"
            :headings="itemData.heading"
            :item-properties="itemData.props"
            :fetch-url="itemToAssignUrl"
            :assign-url="assignUrl"
            :assigned="itemData.assigned"
        ></kelas-assign-modal>

        <kelas-item-setting-modal
            :item="itemData.item"
            ref="settingModal"
            @save:setting="updateSetting"
        ></kelas-item-setting-modal>

        <modal
            id="unassignItemModal"
            :classes="['modal-dialog-centered']"
        >
            <template #header>
                Hapus item dari kelas
            </template>

            <template #body>
                Apakah Anda yakin menghapus item ini dari kelas {{ kelas.nama }}? Semua data kelas {{ kelas.nama }} terkait item ini akan hilang
            </template>

            <template #footer>
                <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Batal</button>
                
                <button 
                    type="button" 
                    class="btn btn-danger" 
                    data-dismiss="modal"
                    @click="unassignItem()"
                >Ya, hapus</button>
            </template>

        </modal>
    
    </div>
</template>

<script>
    export default {
        name: 'kelas-item',

        props: {
            kelas: Object,
            itemData: Object
        },

        data() {
            return {
                listKey: 0,
                loadingSetting: false,

                itemToUnassign: null,
                deleteKey: 0,

                assignUrl: '/api/kelas/' + this.kelas.id + '/assign',
                unassignUrl: '/api/kelas/' + this.kelas.id + '/unassign',

            }
        },

        methods: {
            refreshIndex() {
                this.listKey += 1;
            },

            callUnassign(data) {
                this.itemToUnassign = data
            },

            unassignItem() {
                const itemType = {
                    pelajaran: 'lessons',
                    ujian: 'exams',
                    anggota: 'users'
                }

                let index = this.itemData.assigned.indexOf(this.itemToUnassign.id)
                this.itemData.assigned.splice(index, 1)

                axios.post(this.unassignUrl, {
                    itemId: this.itemToUnassign.id,
                    itemType: itemType[this.itemData.item]
                }).then(response => {
                    this.itemToUnassign = null
                    this.listKey += 1
                }).catch(error => {
                    console.log(error)
                })
            },

            callSetting(index, item) {
                const setting = item.pivot

                EventBus.$emit('setting:get', {
                    kelasId: this.kelas.id,
                    examId: item.id,
                    setting: setting,
                    settingId: index
                })
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
                    kelasId: this.kelas.id,
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
        },

        computed: {
            title() {
                return this.itemData.item.charAt(0).toUpperCase() + this.itemData.item.slice(1);
            },

            settingModal() {
                if (this.itemData.item != 'anggota') {
                    return this.itemData.item + 'SettingModal';                
                }
            },

            itemToAssignUrl() {
                const item = (this.itemData.item == 'anggota') ? 'user' : this.itemData.item

                return '/api/' + item
            }
        },

        created() {
            EventBus.$on('item:assigned', () => {
                this.listKey += 1;
            });

            EventBus.$on('setting:update', (data) => {
                this.$refs.list.laravelData.data[data.settingId].pivot = data.setting
            })
        }
    }
</script>