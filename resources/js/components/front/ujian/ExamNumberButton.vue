<template>
    <button class="btn btn-light btn-sm" :class="isActive" @click="showQuestion">{{ btnNumber }}</button>
</template>

<script>
export default {
    name: 'exam-number-button',

    props: {
        btnNumber: Number,
        id: Number,
        current: Boolean,
    },

    methods: {
        showQuestion() {
            this.$emit('show:question', this.id);
        }
    },

    computed: {
        isActive() {
            return (this.current) ? 'active' : '';
        }
    }
}
</script>