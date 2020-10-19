<div id="anggota" class="tab-pane mt-4">

    <kelas-item-tab
        item="user"
        kelas="{{ $kelas->nama }}"
        :list="true"
        :headings="{{ json_encode($service->users['heading']) }}"
        :item-properties="{{ json_encode($service->users['props']) }}"
        fetch-data="{{ $service->users['fetchUrl'] }}"
        :assigned=" {{ json_encode($service->users['assigned']) }}"
    ></kelas-item-tab>

</div>