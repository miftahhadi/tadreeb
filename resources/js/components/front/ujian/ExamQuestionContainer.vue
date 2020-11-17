<template>

    <div class="card-body" v-html="soal">
    </div>

</template>

<script>
export default {
    name: 'exam-question-container',

    props: {
        soal: String
    },

}
</script>