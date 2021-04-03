<template>
    <div>
        <modal
            id="viewQuestionModal"
            :classes="['modal-dialog-centered', 'modal-lg']"
        >
            <template #header v-if="toView">
                <span>
                    ID Soal: {{ toView.id }}
                </span>
                <a :href="editUrl" class="btn" target="_blank">Edit</a>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </template>

            <template #body>
                <span v-html="toView.konten" v-if="toView != null"></span>
            </template>

            <template #extended-body v-if="toView != null">
                <div class="table-responsive border-top p-3">
                    <table class="table card-table table-vcenter">
                        <tbody>
                            <tr v-for="answer in toView.answers" :key="answer.id">
                                <td class="w-1 text-success" :class="(answer.benar == 1) ? 'text-success' : 'text-danger'">
                                    <i class="fas fa-check-circle fa-lg" v-if="answer.benar == 1"></i>
                                    <i class="fas fa-times-circle fa-lg" v-else></i>
                                </td>
                                <td v-html="answer.redaksi"></td>
                                <td width="20%"><b>Nilai:</b> {{ answer.nilai }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>

        </modal>
    </div>
</template>

<script>
export default {
    name: 'question-viewer',

    data() {
        return {
            toView: {
                id: null,
                konten: null,
                answers: []
            },

            examId: null,
        }
    },

    computed: {
        editUrl() {
            const baseUrl = '/admin/soal/' + this.toView.id
            return (this.examId != null) ? baseUrl + '?ujian=' + this.examId : baseUrl 
        }
    }
}
</script>