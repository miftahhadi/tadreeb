@extends('admin.main')

@section('content')
<div>
    <div class="page-header">
        <h2 class="page-title">Edit Ujian</h2>
    </div>
    <form 
        action="{{ route('admin.ujian.update', $ujian->slug)}}" 
        method="post" 
    >
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col">

                <div class="form-group mb-3">
                    <label class="form-label required">Judul ujian</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="judul" 
                        placeholder="Tuliskan judul" 
                        value="{{ $ujian->judul }}"
                    >

                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>                        
                    @enderror

                   
                </div>

                <div class="form-group mb-3">
                    <label class="form-label required">
                        Slug URL
                    </label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text">{{ $_SERVER['SERVER_NAME'] }}/k/{kelas}/u/</span>
                        </span>
                        <input 
                            type="text" 
                            name="slug" 
                            class="form-control" 
                            value="{{ $ujian->slug }}"
                        >
                    </div>
                    <small class="form-hint">Gunakan (-) sebagai pemisah antar kata, bukan spasi.</small>

                    @error('slug')
                        <small class="text-danger">{{ $message }}</small>                    
                    @enderror
                        
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">
                        Deskripsi
                        <!-- <span class="form-label-description">Maks: 600 karakter</span> -->
                    </label>
                    <textarea class="form-control" name="deskripsi" rows="6" placeholder="Deskripsi...">{{ $ujian->deskripsi }}</textarea>
                
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>                    
                    @enderror

                </div>
    
            </div>
            
            <div class="btn-list">
                <a href="{{ route('admin.ujian.index') }}" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                    Batal
                </a>

                <input type="submit" value="Simpan" class="btn btn-success" :class="disableSubmit">                     
            </div>

        </div>
    </form>
</div>
@endsection