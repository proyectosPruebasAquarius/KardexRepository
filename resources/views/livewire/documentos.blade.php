<div>
    <div id="tipoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tipoModalTitle"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-11 text-center" id="tipoModalLabel">
                        @if ($id_tipo)
                        Actualizar Tipo de Documento
                        @else
                        Agregar Tipo de Documento
                        @endif </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createData" id="tipoForm">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                    @error('nombre')
                        is-invalid
                    @enderror
                    " id="nombre" placeholder="Nombre" wire:model="nombre">
                            <label for="nombre">Nombre</label>
                            @error('nombre') <span class="error">{{ $message }}</span> @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer col-12">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar <i
                            class="material-icons-two-tone text-white">close</i></button>
                    <button type="submit" class="btn  btn-primary" form="tipoForm">
                        @if ($id_tipo)
                        Actualizar
                        @else
                        Guardar
                        @endif
                        <i class="material-icons-two-tone text-white">save</i></button>

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let modal = document.getElementById('tipoModal');

        modal.addEventListener('hide.bs.modal',function(){
            Livewire.emit('resetNamesTipo');
        }) ;
</script>
@endpush