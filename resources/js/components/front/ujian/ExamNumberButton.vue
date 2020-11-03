<template>
    <button class="btn btn-light btn-sm" @click="$emit('show-question', id)">{{ btnNumber }}</button>
</template>

<script>
export default {
    name: 'exam-number-button',

    props: {
        btnNumber: Number,
        id: Number
    }
}
</script>