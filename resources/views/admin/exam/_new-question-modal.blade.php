<div class="modal fade" 
        id="tambahSoal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="tambahSoalLabel" 
        aria-hidden="true"
    >
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <form action="{{ route('admin.ujian.soal.create', ['ujian' => $ujian->id]) }}" method="get">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Soal Baru</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                        @foreach($questionTypes as $question)
                            <label class="form-selectgroup-item flex-fill">
                                <input type="radio" name="type" value="{{ $question['value'] }}" class="form-selectgroup-input" onclick="showChoices(this);">
                                <div class="form-selectgroup-label d-flex align-items-center p-3">
                                    <div class="mr-3">
                                        <span class="form-selectgroup-check"></span>
                                    </div>
                                    <span class="form-selectgroup-label-content">
                                        <span>{{ $question['type'] }}</span>
                                    </span>
                                </div>
                            </label>
                        @endforeach

                        <div class="mt-2">
                            <label for="choices" class="form-label">Jumlah pilihan</label>
                            <input type="number" class="form-control" name="choices" id="choices" value="4" disabled>
                        </div>

                    </div>
                    
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Tambah Soal">
                </div>
            </div>
        </form>
    </div>
</div>