@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            @include('front.ujian._top')

            <div class="row mt-4">
                <div class="col-auto">
                    <h2 class="text-center mb-2">Riwayat Pengerjaan</h2>
                    <span>Nama:  $nama </span>
                </div>
                <div class="col-12 mt-2">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mulai Mengerjakan</th>
                                    <th>Nilai</th>
                                    <th class="w-1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($histories as $key => $history) --}}
                                
                                        <tr>
                                            <td>$history->attempt</td>
                                            <td>
                                                $history->printWaktuMulai() 
                                            </td>
                                            <td>$history->score()</td>
                                            <td>
                                            <a href="#">Lihat</a>
                                            </td>
                                        </tr>
        
                                    {{-- @endforeach --}}
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection