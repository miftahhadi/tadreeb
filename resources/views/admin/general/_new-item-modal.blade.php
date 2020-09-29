<div class="modal fade" 
    id="tambahBaru" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="tambahBaruLabel" 
    aria-hidden="true"
>

  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ujian Baru</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>

      </div>
      
      <div class="modal-body" id="app">
            
          <item-baru-form 
              judul="{{ $judul }}" 
              item="{{ $item }}" 
              action="{{ $action }}" 
              url="{{ $url }}" 
              slug="{{ $slug }}"
          >
            @csrf
          
          </item-baru-form>
            
      </div>
    </div>
  </div>
</div>