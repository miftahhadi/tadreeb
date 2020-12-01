<template>
    <div class="card">
        <div class="dimmer" :class="isLoading">
            
            <div class="loader"></div>
            
            <div class="dimmer-content">
                
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter card-table">

                        <thead>
                            <tr>
                                <th v-for="heading in headings" 
                                    :key="heading.id" 
                                    :width="heading.width"
                                    :class="isId(heading.name)"
                                >{{ heading.name }}</th>
                                
                                <th class="w-2"></th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr v-for="item in items" :key="item.id">
                                <td v-for="$prop in itemProperties" :key="$prop">{{ item[$prop] }}</td>
                                <td>
                                    <item-assign v-if="assign()"
                                        :item-id="item.id"
                                        :assign-url="assignUrl"
                                        :assigned="assigned.includes(item.id)"
                                        @saved="$emit('saved')"
                                    ></item-assign>
                            
                                    <item-action v-else
                                        :item-type="itemType"
                                        :item-slug="item.slug"
                                        :item-id="item.id"
                                        :item-url="itemUrl"
                                        :kelas-id="kelasId"
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
        itemUrl: String,
        actionMode: String,
        assignUrl: String,
        assigned: Array,
        kelasId: Number
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
        },

        isId(name) {
            return (name == 'ID') ? 'w-1' : '';
        },

        assign() {
            return this.actionMode == 'assign'
        },

        kelas() {
            return this.actionMode = 'kelas'
        }
    }
}
</script>