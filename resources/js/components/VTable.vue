<template>
    <div class="table-responsive">
        <table class="table table-hover table-vcenter card-table">

            <thead>
                <tr>
                    <th v-for="heading in headings" 
                        :key="heading.id" 
                        :width="heading.width"
                    >{{ heading.name }}</th>
                    
                    <th class="w-2" v-if="action"></th>
                </tr>
            </thead>

            <tbody>

                <tr v-for="(item, index) in itemData" :key="item.id">
                    <td v-for="$prop in properties" :key="$prop">{{ printItem(index,$prop) }}</td>

                    <td v-if="action">
                        <slot name="action" :item="item">

                        </slot>
                    </td>
                </tr>

            </tbody>

        </table>
    </div>
</template>

<script>
export default {
    name: 'v-table',
    
    props: {
        headings: {
            type: Array,
            required: true
        },
        properties: {
            type: Array,
            required: true
        },
        itemData: {
            type: Array,
        },
        action: Boolean
    },

    methods: {
        printItem(index, prop) {
            if (prop.includes('.')) {
                const props = prop.split('.',2)

                return this.itemData[index][props[0]][props[1]]
            } else {
                return this.itemData[index][prop]
            }
        }
    }
}
</script>