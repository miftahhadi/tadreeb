<template>
    <div>

        <ul class="nav nav-tabs">
            <li class="nav-item" v-for="tab in tabs" :key="tab.name">
                <a :href="tab.href" class="nav-link" :class="{ 'active': tab.isActive }" @click="selectTab(tab)">{{ tab.name }}</a>
            </li>
        </ul>

        <div class="content-tab mt-4">
            <slot></slot>
        </div>

    </div>
    
</template>

<script>
export default {
    name: 'item-tab',

    data() {
        return {
            tabs : []
        }
    },

    created() {
        this.tabs = this.$children
    },

    methods: {
        selectTab(selected) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.name == selected.name)
            })
        }
    }
}
</script>