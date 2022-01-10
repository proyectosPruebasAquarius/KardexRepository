<div>
    <div>
        <div id="inventarioModal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="inventarioModalTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-11 text-center" id="inventarioModalLabel" > 
                         @if ($id_inventario)
                        Actualizar Inventario
                        @else
                        Agregar Inventario
                        @endif </h5>
                    <button type="button" class="btn-close" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createInventario" id="productoForm">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control 
                        @error('min')
                            is-invalid
                        @enderror
                        " id="min" placeholder="Cantidad Minima" wire:model="min">
                            <label for="producto">Cantidad Minima</label>
                            @error('min') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control 
                        @error('max')
                            is-invalid
                        @enderror
                        " id="max" placeholder="Cantidad Maxima" wire:model="max">
                            <label for="max">Cantidad Maxima</label>
                            @error('max') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">  
                            <select name="producto" id="producto" class="form-select 
                            @error('producto')
                                is-invalid
                            @enderror
                            " wire:model="producto" >
                            <option selected >Seleciona una opción</option>
                            @forelse ($productos as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @empty
                            <option value="0" disabled>No hay Opciones Disponibles</option>
                            @endforelse
                            </select>                                                         
                            <label for="producto">Producto</label>
                            @error('producto') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">  
                            <select name="almacen" id="almacen" class="form-select 
                            @error('almacen')
                                is-invalid
                            @enderror
                            " wire:model="almacen" >
                            <option selected >Seleciona una opción</option>
                            @forelse ($almacenes as $a)
                            
                            <option  value="{{ $a->id }}">{{ $a->nombre }}</option>
                            
                                  
                            @empty
                            <option value="0" disabled>No hay Opciones Disponibles</option>
                            @endforelse
                            </select>                                                         
                            <label for="almacen">Almacenes</label>
                            @error('almacen') <span class="error">{{ $message }}</span> @enderror
                        </div>


                       
                    </form>
                </div>
                <div class="modal-footer col-12">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar <i
                            class="material-icons-two-tone text-white">close</i></button>
                    <button type="submit" class="btn  btn-primary" form="productoForm">
                        @if ($id_inventario)
                        Actualizar
                        @else
                        Guardar
                        @endif 
                    <i
                            class="material-icons-two-tone text-white">save</i></button>
    
                </div>
            </div>
        </div>
    </div>
    </div>
    @push('scripts')
        <script>
            let modal = document.getElementById('inventarioModal');
    
            modal.addEventListener('hide.bs.modal',function(){
                Livewire.emit('resetNamesInventarios');
            }) ;
    
            window.addEventListener('closeModal', event => {
            $("#inventarioModal").modal('hide');  
              
              
            });
    
         
    
        </script>
    @endpush
    
    
</div>
