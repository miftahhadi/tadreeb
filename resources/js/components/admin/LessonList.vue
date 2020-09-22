<template>
    <div>
        <div class="card">
            <div class="table-responsive">

                <table class="table table-vcenter table-hover card-table">

                <thead>
                    <tr>
                        <th class="w-1">ID</th>
                        <th width="60%">Judul</th>
                        <th>Kategori</th>
                        <th class="w-2"></th>
                    </tr>
                </thead>

                <tbody>

                    <tr v-for="lesson in lessons" :key="lesson.id">
                        <td>{{ lesson.id }}</td>
                        <td>{{ lesson.judul }}</td>
                        <td>Kategori</td>
                        <td>
                            <item-action></item-action>
                        </td>
                    </tr>

                </tbody>

                </table>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'lesson-list',

    props: {
        lessons: Array,
    }
}
</script>