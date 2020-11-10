<template>
    <button class="btn btn-sm" :class="[isActive, isAnswered]" @click="showQuestion">{{ btnNumber }}</button>
</template>

<script>
export default {
    name: 'exam-number-button',

    props: {
        btnNumber: Number,
        id: Number,
        current: Boolean,
        answered: Boolean,
    },

    methods: {
        showQuestion() {
            this.$emit('show:question', this.id);
        }
    },

    computed: {
        isActive() {
            return (this.current) ? 'active' : '';
        },

        isAnswered() {
            return (this.answered) ? 'btn-success' : 'btn-light'
        }
    }
}
</script>