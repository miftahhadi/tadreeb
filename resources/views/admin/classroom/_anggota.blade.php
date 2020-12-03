<div id="anggota" class="tab-pane mt-4">

    <kelas-item
        item="user"
        kelas="{{ $kelas->nama }}"
        :kelas-id="{{ $kelas->id }}"
        :list="true"
        :headings="{{ json_encode($service->users['heading']) }}"
        :item-properties="{{ json_encode($service->users['props']) }}"
        fetch-data="{{ $service->users['fetchUrl'] }}"
        :assigned=" {{ json_encode($service->users['assigned']) }}"
    ></kelas-item>

</div>