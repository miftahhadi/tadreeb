<template>
    <div class="tab-pane" v-show="isActive">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'tab-details',

    props: {
        name: {
            type: String,
            required: true
        },

        selected: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            isActive: this.selected
        }
    },
    
    computed: {
        href() {
            return '#' + this.name.toLowerCase().replace(/ /g, '-');
        }
    }
}
</script>