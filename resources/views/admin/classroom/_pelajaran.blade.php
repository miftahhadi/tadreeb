<div id="pelajaran" class="tab-pane mt-4">
    
    <kelas-item-tab
        item="pelajaran"
        kelas="{{ $kelas->nama }}"
        :list="true"
        :headings="{{ json_encode($service->lessons['heading']) }}"
        :item-properties="{{ json_encode($service->lessons['props']) }}"
        fetch-data="{{ $service->lessons['fetchUrl'] }}"
        :assigned="{{ json_encode($service->lessons['assigned']) }}"
    ></kelas-item-tab>
    
</div>