<div>
    <!-- Modal -->
    <div id="updateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateModalTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalTitle">Actualizar un usuario</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createData" id="formUpdate">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                            @error('name')
                                is-invalid
                            @enderror
                            " id="nameU" placeholder="Nombre y Apellidos" wire:model="name">
                            <label for="nameU">Nombres y Apellidos</label>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control
                            @error('email')
                                is-invalid
                            @enderror
                            " id="emailU" placeholder="Correo Electrónico" wire:model="email">
                            <label for="emailU">Correo Electrónico</label>
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" aria-describedby="emailHelp" class="form-control
                            @error('password')
                                is-invalid
                            @enderror
                            " id="passwordU" placeholder="Contraseña" wire:model="password">
                            <label for="passwordU">Contraseña</label>
                            <h1 id="emailHelp" class="form-text text-danger">Deja esta campo vacio, editalo unicamente si actualizarás la contraseña.</h1>
                            @error('password') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </form>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn  btn-primary" form="formUpdate">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>
