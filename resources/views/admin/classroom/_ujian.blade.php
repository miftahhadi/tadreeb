<div id="ujian" class="tab-pane mt-4">
    
    <kelas-item-tab
        item="ujian"
        kelas="{{ $kelas->nama }}"
        :kelas-id="{{ $kelas->id }}"
        :list="true"
        :headings="{{ json_encode($service->exams['heading']) }}"
        :item-properties="{{ json_encode($service->exams['props']) }}"
        fetch-data="{{ $service->exams['fetchUrl'] }}"
        :assigned=" {{ json_encode($service->exams['assigned']) }}"
    ></kelas-item-tab>

</div>