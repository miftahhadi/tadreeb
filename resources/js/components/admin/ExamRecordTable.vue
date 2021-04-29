<template>
    <div>
        <div class="btn-list">
            <button class="btn" :class="{ 'bg-indigo-lt': show == 'all' }" @click="changeData('all')">Semua anggota kelas</button>
            <button class="btn" :class="{ 'bg-indigo-lt': show =='done' }" @click="changeData('done')">Sudah mengerjakan</button>
            <button class="btn" :class="{ 'bg-indigo-lt': show =='unfinished' }" @click="changeData('unfinished')">Belum mengerjakan</button>
        </div>
        
        <div class="mt-3" v-if="show == 'done'"><strong>Catatan:</strong> Nilai yang ditampilkan adalah nilai saat user terakhir kali mengerjakan ujian.</div>

        <div class="card mt-2">
            <v-table
                :order="true"
                :headings="headings[show]"
                :properties="properties[show]"
                :item-data="records"
                :action="actionColumn"
            >
                <template v-slot:action="actionProps">
                    <div class="d-flex small">
                        <a :href="'/admin/ujian/' + exam.id + '/detail?kelasId=' + recordData.kelas.id + '&userId=' + actionProps.item.id" class="btn btn-sm btn-link">Lihat</a>
                        <a :href="'/admin/ujian/' + exam.id + '/kelas?kelasId=' + recordData.kelas.id + '&userId=' + actionProps.item.id" class="btn btn-sm btn-link">Riwayat</a>
                    </div>
                </template>

            </v-table>
        </div>

    </div>
</template>

<script>
export default {
    name: 'exam-record-table',

    props: {
        exam: Object,
        recordData: Object,
    },

    data() {
        return {
            headings: {
                all: [
                    {
                        name: 'Nama',
                        width: null
                    },
                    {
                        name: 'Username',
                        width: null
                    },
                    {
                        name: 'Sudah Mengerjakan?',
                        width: null
                    }
                ],

                done: [
                    {
                        name: 'Nama',
                        width: null
                    },
                    {
                        name: 'Username',
                        width: null
                    },
                    {
                        name: 'Waktu Mengerjakan',
                        width: null
                    },
                    {
                        name: 'Nilai',
                        width: null
                    }
                ],
                
                unfinished: [
                    {
                        name: 'Nama',
                        width: null
                    },
                    {
                        name: 'Username',
                        width: null
                    },
                ] 
            },
            properties: {
                all: ['name', 'username', 'has_done_exam'],
                done: ['name', 'username', 'waktu_mulai', 'score'],
                unfinished: ['name', 'username']
            },
            records: [],

            actionColumn: false,

            show: 'all',
        }
    },

    methods: {
        changeData(show) {
            this.show = show

            switch (show) {
                case 'all':
                    this.records = this.recordData.row
                    this.actionColumn = false
                    break;

                case 'done':
                    this.records = this.recordData.row.filter(user => {
                        return user.has_done_exam == 'Sudah'
                    })
                    this.actionColumn = true
                    break;

                case 'unfinished':
                    this.records = this.recordData.row.filter(user => {
                        return user.has_done_exam == 'Belum'
                    })
                    this.actionColumn = false
                    break;
            }

        },
    },

    created() {
        this.records = this.recordData.row
    }

}
</script>