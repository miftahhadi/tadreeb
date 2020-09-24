<template>
    <div>
        <div class="card" :class="isLoading">
            <div class="table-responsive">

                <table class="table table-vcenter table-hover card-table">

                <thead>
                    <tr>
                        <th class="w-1">ID</th>
                        <th v-for="heading in headings" :key="heading.id" :width="heading.width">{{ heading.name }}</th>
                        <!-- <th width="60%">Judul</th>
                        <th>Kategori</th> -->
                        <th class="w-2"></th>
                    </tr>
                </thead>

                <tbody>

                    <tr v-for="item in items" :key="item.id">
                        <td v-for="$prop in itemProperties" :key="$prop">{{ item[$prop] }}</td>
                        <td>
                            <item-action
                                :item-name="itemName"
                                :item-slug="item.slug"
                            ></item-action>
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
    name:'item-list',

    props: {
        itemName: String,
        items: Array,
        loading: Boolean,
        headings: Array,
        itemProperties: Array,
    },

    data() {
        return {
            $title: 'judul',
        }
    },

    computed: {
        isLoading() {
            return this.loading ? 'spinner-border' : '';
        }
    }
}
</script>