<template>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Soal ke-1 dari 50</h3>
                </div>

                <div class="card-body">
                    ....
                </div>

                <div class="card-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-white">
                            <i class="fas fa-chevron-circle-left"></i>
                            <span class="ml-1">Sebelumnya</span>
                        </a>

                        <a href="#" class="btn btn-success">Jawab</a>
                        
                        <a href="#" class="btn btn-white">
                            <span class="mr-1">Lewati</span>
                            <i class="fas fa-chevron-circle-right"></i>
                        </a>
                    </div>
                    
                </div>

            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Direktori Soal</h3>
                </div>

                <div class="card-body">
                    <div class="btn-list justify-content-center">

                        <a href="" class="btn btn-light btn-sm" v-for="i in 50" :key="i">{{ i }}</a>

                    </div>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: 'exam-doing-page',

    props: {
        examId: Number
    }
}
</script>