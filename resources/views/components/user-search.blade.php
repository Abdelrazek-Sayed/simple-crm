 <div class="d-flex justify-content-center align-items-center border">
     <input {{ $attributes }}  type="search" placeholder="search" class="form-control  border-0" />
     <div class="fa-2x pr-2" wire:loading  wire:target="search">
         <i class="fas fa-spinner fa-spin"></i>
         {{-- <i class="fas fa-circle-notch fa-spin"></i> --}}
     </div>
 </div>



 