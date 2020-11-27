@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            @include('front.ujian._top')

            <div class="row mt-4">
                <div class="col-auto">
                    <h2 class="page-title">Riwayat Pengerjaan</h2>
                    <h3>Nama: </h3>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mulai Mengerjakan</th>
                                    <th>Selesai Mengerjakan</th>
                                    <th>Kali Mengerjakan</th>
                                    <th class="w-1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $key => $history)
                                
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $history->waktu_mulai }}</td>
                                            <td>
                                            {{ $history->waktu_selesai }}
                                            </td>
                                            <td>{{ $history->attempt }}</td>
                                            <td>
                                            <a href="#">Lihat</a>
                                            </td>
                                        </tr>
        
                                    @endforeach
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection