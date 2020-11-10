<template>
    <div>
        <div class="row">
            <div class="col">
                <h2>Konten {{ title }}</h2>
            </div>

            <div class="col-auto ml-auto">
                <button class="btn btn-primary" 
                        data-toggle="modal" 
                        data-target="#assignExamModal"
                >Tambah Ujian</button>
            </div>
        </div>

        <div class="box" :key="indexKey">
            <div class="card">
            <div class="table-responsive">
    
                <table class="table table-vcenter table-hover card-table">
    
                <thead>
                    <tr>
                        <th width="50%">Konten</th>
                        <th width="30%">Tipe</th>
                        <th></th>
                    </tr>
                </thead>
    
                <tbody>
                    <tr v-for="exam in assignedExams" :key="exam.id">
                        <td>{{ exam.judul }}</td>
                        <td>{{ exam.pivot.sectionable_type }}</td>
                        <td>
                            <a href="#" class="btn btn-light btn-sm">Pengaturan</a>
                            <a href="#" class="btn btn-danger btn-sm">Keluarkan</a>
                        </td>
                    </tr>
    
                </tbody>
    
                </table>
    
            </div>
            </div>
        </div>

        <section-assign-exam
            item="ujian"
            fetch-url="/api/ujian"
            :assignUrl="assignExamUrl"
            :section="title"
            :assigned="assignedExamsId"
            @saved="reload"
        >
        </section-assign-exam>

    </div>
</template>

<script>
export default {
    name: 'section-page',

    props: {
        title: String,
        assignExamUrl: String,
        assignedExamsId: Array,
        assignedExams: Array,
    },

    data() {
        return {
            indexKey: 0
        }
    },

    methods: {
        reload() {
            this.indexKey += 1;
        }
    }
}
</script>