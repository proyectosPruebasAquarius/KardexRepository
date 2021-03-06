<div>    
    <!-- Modal -->
    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createData" id="formA">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                            @error('nombre')
                                is-invalid
                            @enderror
                            " id="nombre" placeholder="Nombre" wire:model="nombre">
                            <label for="nombre">Nombre</label>
                            @error('nombre') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        {{-- <div class="form-floating mb-3">
                            <input type="text" class="form-control
                            @error('direccion')
                                is-invalid
                            @enderror
                            " id="direccion" placeholder="Dirección" wire:model="direccion">
                            <label for="direccion">Dirección</label>
                            @error('direccion') <span class="error">{{ $message }}</span> @enderror
                        </div> --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control
                            @error('zonas')
                                is-invalid
                            @enderror
                            " id="zonas" placeholder="Zonas" wire:model="zona" wire:key="focused">
                            <label for="zonas">{{ $focused  ? 'Zonas | Separe con coma para agregar mas de una zona' : 'Zonas' }}</label>
                            @error('zonas') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </form>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">{{ $idDireccion ? 'Cancelar' : 'Cerrar' }}</button>
                    <button type="submit" class="btn  btn-primary" form="formA">{{ $idDireccion ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            'use strict';

            document.getElementById('zonas').addEventListener('focus', function () {
                /* document.querySelector('label[for="zonas"]').innerText = 'Zonas | Separe con comas para agregar mas de una zona'; */
                @this.focused = true;
            })

            document.getElementById('zonas').addEventListener('blur', function (e) {
                if (e.target.value == '') {
                    /* document.querySelector('label[for="zonas"]').innerText = 'Zonas'; */
                    @this.focused = false;
                }                
            })

            document.getElementById('zonas').addEventListener('keypress', function (e) {
                console.log(e.which);
                if (e.which === 32) {
                    e.preventDefault()
                }
            })
        </script>
    @endpush
</div>

