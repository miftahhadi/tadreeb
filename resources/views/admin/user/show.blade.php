@extends('admin.main')

@section('content')

    @include('admin._item-header')

    <a href="{{ route('admin.user.edit', ['user' => $user->id]) }}" class="btn">
        <span>
            <!-- Download SVG icon from http://tabler-icons.io/i/pencil -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><line x1="13.5" y1="6.5" x2="17.5" y2="10.5" /></svg>
        </span>
        Edit profil
    </a>

    <div class="card my-2">
        <div class="card-header">Info akun</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-3"><strong>Nama:</strong></dt>
                <dd class="col-9">{{ $user->name }}</dd>
                <dt class="col-3">Username:</dt>
                <dd class="col-9">{{ $user->username }}</dd>
                <dt class="col-3">Email:</dt>
                <dd class="col-9">{{ $user->email }}</dd>
                <dt class="col-3">Peran:</dt>
                <dd class="col-9">{{ $user->getRoleDisplayName() }}</dd>
            </dl>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">Profil User</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-3"><strong>Jenis kelamin:</strong></dt>
                <dd class="col-9">{{ $user->profile->gender }}</dd>
                <dt class="col-3">Tanggal lahir:</dt>
                <dd class="col-9">{{ $user->profile->tanggal_lahir_string }}</dd>
                <dt class="col-3">WhatsApp:</dt>
                <dd class="col-9">{{ $user->profile->whatsapp }}</dd>
                <dt class="col-3">Telegram:</dt>
                <dd class="col-9">{{ $user->profile->telegram }}</dd>
            </dl>
        </div>
    </div>

@endsection