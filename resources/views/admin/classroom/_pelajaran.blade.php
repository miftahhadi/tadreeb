<div id="pelajaran" class="tab-pane mt-4">
    
    <kelas-item
        item="pelajaran"
        kelas="{{ $kelas->nama }}"
        :kelas-id="{{ $kelas->id }}"
        :list="true"
        :headings="{{ json_encode($service->lessons['heading']) }}"
        :item-properties="{{ json_encode($service->lessons['props']) }}"
        fetch-data="{{ $service->lessons['fetchUrl'] }}"
        :assigned="{{ json_encode($service->lessons['assigned']) }}"
    ></kelas-item>
    
</div>