<div>
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
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control
                            @error('direccion')
                                is-invalid
                            @enderror
                            " id="direccion" placeholder="Dirección" wire:model="direccion">
                            <label for="direccion">Dirección</label>
                            @error('direccion') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control
                            @error('telefono')
                                is-invalid
                            @enderror
                            " id="telefono" placeholder="Teléfono" wire:model="telefono">
                            <label for="telefono">Teléfono</label>
                            @error('telefono') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                            @error('web')
                                is-invalid
                            @enderror
                            " id="web" placeholder="web" wire:model="web">
                            <label for="web">Web</label>
                            @error('web') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                            @error('encargado')
                                is-invalid
                            @enderror
                            " id="encargado" placeholder="encargado" wire:model="encargado">
                            <label for="encargado">Encargado</label>
                            @error('encargado') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                            @error('encargado_tel')
                                is-invalid
                            @enderror
                            " id="encargado_tel" placeholder="encargado_tel" wire:model="encargado_tel" maxlength="12">
                            <label for="encargado_tel">Encargado Teléfono</label>
                            @error('encargado_tel') <span class="error">{{ $message }}</span> @enderror
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
</div>
