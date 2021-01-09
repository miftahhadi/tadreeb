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

                <tr v-for="item in data" :key="item.id">
                    <td v-for="$prop in properties" :key="$prop">{{ item[$prop] }}</td>
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
    name: 'data-table',
    
    props: {
        headings: {
            type: Array,
            required: true
        },
        properties: {
            type: Array,
            required: true
        },
        data: {
            type: Array,
        },
        action: Boolean
    }
}
</script>