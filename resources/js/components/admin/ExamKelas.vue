<template>
    <div>
        <item-list
            item="kelas"
            :fetch-url="'/api/ujian/' + examId + '/kelas'"
            :table-heading="tableHeading"
            :item-properties="itemProperties"
            :action="true"
        >
            <template v-slot:action="actionProp">
                <div class="btn-list flex-nowrap">
                    <a href="#" class="btn btn-sm">Pengaturan</a>
                    <a :href="'/admin/ujian/' + examId + '/hasil?kelas=' + actionProp.item.id " class="btn btn-sm">Hasil</a>
                </div>
            </template>
        </item-list>
    </div>
</template>

<script>
export default {
    name: 'exam-kelas',

    props: {
        examId: Number,
        tableHeading: Array,
        itemProperties: Array
    }
}
</script>