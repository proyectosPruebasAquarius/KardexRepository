<div>
    <div id="modalZonas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalZonasTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalZonasTitle">{{ $idZona ? 'Actualizar' : 'Guardar' }} Zona</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createData" id="formAzonas">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                            @error('nombre')
                                is-invalid
                            @enderror
                            " id="nombre" placeholder="Nombre" wire:model="nombre" aria-describedby="hint">
                            <label for="nombre">Nombre</label>
                            <div id="hint" class="form-text">Separa con coma para agregar mas de una zona</div>
                            @error('nombre') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <button type="button" class="buttonD">
                            <div class="trash">
                                <div class="top">
                                    <div class="paper"></div>
                                </div>
                                <div class="box"></div>
                                <div class="check">
                                    <svg viewBox="0 0 8 6">
                                        <polyline points="1 3.4 2.71428571 5 7 1"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <span>Eliminar Zona</span>
                        </button>
                    </form>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">{{ $idZona ? 'Cancelar' : 'Cerrar' }}</button>
                    <button type="submit" class="btn  btn-primary" form="formAzonas">{{ $idZona ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            'use strict';

            document.querySelectorAll('.buttonD').forEach(button => button.addEventListener('click', e => {
                if(!button.classList.contains('delete')) {
                    button.classList.add('delete');
                    /* setTimeout(() => button.classList.remove('delete'), 3200); */
                    setTimeout(() => {
                        button.classList.remove('delete')
                        @this.trash();
                    }, 3200);
                    
                }
                e.preventDefault();
            }));

            var modalZonas = document.getElementById('modalZonas')
            modalZonas.addEventListener('hide.bs.modal', function () {
                Livewire.emit('resetDataZ')
            })

            window.addEventListener('close-modal', event => {
                $("#modalZonas").modal('hide');
            });
            /* let trash = () => {

            } */
        </script>
    @endpush    
</div>
