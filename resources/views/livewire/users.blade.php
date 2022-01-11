<div>
    <!-- Modal -->
    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ $idUser ? 'Actualizar un usuario' : 'Crear un nuevo usuario' }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createData" id="formA">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                            @error('name')
                                is-invalid
                            @enderror
                            " id="name" placeholder="Nombre y Apellidos" wire:model="name">
                            <label for="name">Nombres y Apellidos</label>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control
                            @error('email')
                                is-invalid
                            @enderror
                            " id="email" placeholder="Correo Electrónico" wire:model="email">
                            <label for="email">Correo Electrónico</label>
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control
                            @error('password')
                                is-invalid
                            @enderror
                            " id="password" placeholder="Contraseña" wire:model="password">
                            <label for="password">Contraseña</label>
                            @error('password') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </form>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">{{ $idUser ? 'Cancelar' : 'Cerrar' }}</button>
                    <button type="submit" class="btn  btn-primary" form="formA">{{ $idUser ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
