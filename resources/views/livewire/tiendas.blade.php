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
                            @error('codigo')
                                is-invalid
                            @enderror
                            " id="codigo" placeholder="codigo" wire:model="codigo">
                            <label for="codigo">Código</label>
                            @error('codigo') <span class="error">{{ $message }}</span> @enderror
                        </div>
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
                            <select 
                                id="almacen"
                                wire:model="id_almacen" 
                                class="form-control 
                                @error('id_almacen')
                                    is-invalid
                                @enderror">
                                @forelse ($almacenes as $alm)
                                    @if ($loop->first)
                                        <option style="display:none">Seleccione una opción</option>
                                        
                                        
                                        
                                    @endif
                                    <option value="{{ $alm->value }}">{{ $alm->label }}</option>
                                @empty
                                    <option>Ocurrió un error, porfavor agregue nuevos almacenes</option>
                                @endforelse
                            </select>
                            <label for="almacen">Almacen</label>
                            @error('id_almacen') <span class="error">{{ $message }}</span> @enderror
                        </div>
                            {{-- @livewire('tiendas-auto-complete') --}}                            
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
            /* let almacenes = @js($almacenes);
            console.log(almacenes);
            var datasrc = Array.from(almacenes)                                   
            
            const ac = new Autocomplete(document.getElementById('id_almacen'), {
                data: datasrc,
                onSelectItem: ({label, value}) => {
                    @this.id_almacen = value
                    @this.almacen = label
                    console.log("user selected:", label, value);
                }
            });

            let form = document.querySelector('#formA')
            form.querySelector('.dropdown-menu') */
            /* console.log(@js($errors->get('id_almacen'))) */;
        </script>
    @endpush
</div>
