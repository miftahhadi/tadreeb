<h2 class="h1 font-weight-bold">{{ $itemName ?? '' }}</h2>

@if ($itemDescription)
    <div class="mt-2">
        <span class="text-muted">Deskripsi</span>
        <p>
            {!! $itemDescription !!}
        </p>
    </div>    
@endif
