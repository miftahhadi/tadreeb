<template>
    <div class="modal fade" id="settingModal" tabindex="-1" aria-labelledby="settingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="modal-header">
                        <h3 class="modal-title">Pengaturan Ujian</h3>
                    </div>
                    
                    <div class="modal-body">
                        
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Tampilkan ujian?</label>
                            <div class="col">
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tampil" value="1">
                                        <span class="form-check-label">Ya</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tampil" value="0">
                                        <span class="form-check-label">Tidak</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Buka akses?</label>
                            <div class="col">
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="buka" value="1">
                                        <span class="form-check-label">Buka</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="buka" value="0">
                                        <span class="form-check-label">Tutup</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Buka hasil?</label>
                            <div class="col">
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="buka_hasil" value="1">
                                        <span class="form-check-label">Buka</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="buka_hasil" value="0">
                                        <span class="form-check-label">Tutup</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Tampilkan otomatis pada</label>
                            <div class="col">
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="date" class="form-control" name="tampil_otomatis[tanggal]" value="">
                                    </div>
                                    <div class="col-auto">
                                        <input type="time" class="form-control" name="tampil_otomatis[waktu]" value="">
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Buka akses otomatis pada</label>
                            <div class="col">
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="date" class="form-control" name="buka_otomatis[tanggal]" value="">
                                    </div>
                                    <div class="col-auto">
                                        <input type="time" class="form-control" name="buka_otomatis[waktu]" value="">
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Tutup akses otomatis pada</label>
                            <div class="col">
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="date" class="form-control" name="batas_buka[tanggal]" value="">
                                    </div>
                                    <div class="col-auto">
                                        <input type="time" class="form-control" name="batas_buka[waktu]" value="">
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Durasi</label>
                            <div class="col-auto">

                                <input type="number" class="form-control" name="durasi" value="">
                                
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Kesempatan mencoba</label>
                            <div class="col-auto">

                                <input type="number" class="form-control" name="attempt" value="">
                                
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="submit" value="Simpan" class="btn btn-success">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'kelas-item-setting-modal'
}
</script>