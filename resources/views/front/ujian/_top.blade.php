<ol class="breadcrumb breadcrumb-arrows mb-2" aria-label="breadcrumbs">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">
        <a href="{{ route('kelas.home', $kelas->kode) }}">Kelas {{ $kelas->nama }}</a>
    </li>
</ol>

<div class="card card-sm bg-blue text-white rounded-lg">
    <div class="card-body pt-4">
        <h2 class="h1 font-weight-bold">
            <a href="{{ route('kelas.exam.info', ['kelas' => $kelas->kode, 'exam' => $exam->slug]) }}">{{ $exam->judul }}</a>
        </h2>
    </div>
</div>