<template>
    <div>

        <ul class="nav nav-tabs">
                
            <li class="nav-item" v-for="(menu, index) in kelas.navMenu" :key="index">
                <a :href="'#' + menu.toLowerCase()" 
                    class="nav-link" 
                    data-toggle="tab"
                    :class="isActive(index)"
                >{{ menu }}</a>
            </li>

        </ul>

        <div class="tab-content">
            <kelas-item-tab
                id="ikhtisar"
                kelas="kelas.nama"
            ></kelas-item-tab>

            <kelas-item-tab
                id="pelajaran"
                kelas="kelas.nama"
                :list="true"
                :headings="kelas.pelajaran.tableHeadings"
                :item-properties="kelas.pelajaran.itemProps"
                :fetch-url="kelas.pelajaran.fetchUrl"
            ></kelas-item-tab>

            <kelas-item-tab
                id="ujian"
                kelas="kelas.nama"
            ></kelas-item-tab>

            <kelas-item-tab
                id="anggota"
                kelas="kelas.nama"
            ></kelas-item-tab>

            <kelas-item-tab
                id="pengaturan"
                kelas="kelas.nama"
            ></kelas-item-tab>

        </div>

    </div>
</template>

<script>
export default {
    name: 'kelas-index',

    props: {
        kelas: Object
    },

    methods: {
        isActive: function(index) {
            return (index == 0) ? 'active' : '';
        }
    }
}
</script>