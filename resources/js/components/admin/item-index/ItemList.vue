<template>
    <div class="card">
        <div class="dimmer" :class="isLoading">
            
            <div class="loader"></div>
            
            <div class="dimmer-content">
                <div class="table-responsive">

                    <table class="table table-vcenter table-hover card-table">

                        <thead>
                            <tr>
                                <th class="w-1">ID</th>
                                <th v-for="heading in headings" 
                                    :key="heading.id" 
                                    :width="heading.width"
                                >{{ heading.name }}</th>
                                
                                <th class="w-2"></th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr v-for="item in items" :key="item.id">
                                <td v-for="$prop in itemProperties" :key="$prop">{{ item[$prop] }}</td>
                                <td>
                                    <item-action
                                        :item-type="itemType"
                                        :item-slug="item.slug"
                                        :item-id="item.id"
                                        @delete:item="deleteItem"
                                    ></item-action>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name:'item-list',

    props: {
        itemType: String,
        items: Array,
        loading: Boolean,
        headings: Array,
        itemProperties: Array,
    },

    computed: {
        isLoading() {
            return this.loading ? 'active' : '';
        }
    },

    methods: {
        deleteItem(id) {
            let data = this.items.find(item => item.id == id);
            this.$emit('delete:item', data);
        }
    }
}
</script>