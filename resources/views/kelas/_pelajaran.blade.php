<div id="pelajaran" class="tab-pane active show">
    <div class="mt-4">
        <div class="row">
            <div class="col">
                <h2>Pelajaran</h2>
            </div>

            <div class="col-auto ml-auto">
                <a href="#" class="btn btn-primary">Tambah Pelajaran</a>
            </div>
        </div>

        <div class="mt-5">
            <item-index
                item="pelajaran"
                fetch-url="{{ '/api/kelas/' . $kelas->id . '/pelajaran'}}"
                :table-heading="{{ $tableHeading }}"
                :item-properties="{{ $itemProperties }}"
            ></item-index>
        </div>


    </div>
</div>