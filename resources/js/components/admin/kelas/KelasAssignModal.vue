<template>

    <div>
        <form @submit.prevent="massAssign">
            <modal :id="'assign' + title + 'Modal'" 
                :classes="['modal-lg', 'modal-dialog-centered']"
            >

                <template #title>Tambahkan {{ title }} ke Kelas {{ kelas }}</template>

                <template #body>
                    <item-list
                        :item="item"
                        :table-heading="headings"
                        :item-properties="itemProperties"
                        :fetch-url="fetchUrl"
                        :search="true"
                    >
                    
                        <template v-slot:action="actionProp">
                            <item-assign
                                :item-type="itemType[item]"
                                :item-id="actionProp.item.id"
                                :assign-url="assignUrl"
                                :assigned="assigned.includes(actionProp.item.id)"
                            ></item-assign>
                        </template>
                    
                    </item-list>

                </template>

                <template #footer>
                    <button class="btn" data-dismiss="modal">Batal</button>
                    <!-- <input type="submit" value="Tambahkan" class="btn btn-success"> -->
                </template>

            </modal>
        </form>

    </div>
    
</template>

<script>
export default {
    name: 'kelas-assign-modal',

    props: {
        item: String,
        kelas: String,
        fetchUrl: String,
        headings: Array,
        itemProperties: Array,
        assignUrl: String,
        assigned: Array,
    },

    data() {
        return {
            laravelData: {},
            loading: false,
            query: '',
            itemId: [],
            
            itemType: {
                pelajaran: 'lessons',
                ujian: 'exams',
                user: 'users'
            }
        }
    },

    methods: {
        massAssign() {

        }
    },

    computed: {
        title() {
            if (this.item == 'user') {
                return 'Anggota';
            } else {
                return this.item.charAt(0).toUpperCase() + this.item.slice(1);
            }
        }
    },
}
</script>