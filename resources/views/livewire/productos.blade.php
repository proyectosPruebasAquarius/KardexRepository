<div>
    <div>
        <div id="productoModal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="productoModalTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-11 text-center" id="productoModalLabel" > 
                         @if ($id_producto)
                        Actualizar Producto
                        @else
                        Agregar Producto
                        @endif </h5>
                    <button type="button" class="btn-close" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createProducto" id="productoForm">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                        @error('producto')
                            is-invalid
                        @enderror
                        " id="producto" placeholder="Nombre" wire:model="producto">
                            <label for="producto">Nombre</label>
                            @error('producto') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                        @error('cod_producto')
                            is-invalid
                        @enderror
                        " id="cod_producto" placeholder="Codigo del Producto" wire:model="cod_producto">
                            <label for="cod_producto">Codigo del Producto</label>
                            @error('cod_producto') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">  
                            <select name="marca" id="marca" class="form-select 
                            @error('marca')
                                is-invalid
                            @enderror
                            " wire:model="marca" >
                            <option selected >Seleciona una opción</option>
                            @forelse ($marcas as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                            @empty
                            <option value="0" disabled>No hay Opciones Disponibles</option>
                            @endforelse
                            </select>                                                         
                            <label for="marca">Marca</label>
                            @error('marca') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">  
                            <select name="categoria" id="categoria" class="form-select 
                            @error('categoria')
                                is-invalid
                            @enderror
                            " wire:model="categoria" >
                            <option selected >Seleciona una opción</option>
                            @forelse ($categorias as $c)
                            
                            <option  value="{{ $c->id }}">{{ $c->nombre }}</option>
                            
                                  
                            @empty
                            <option value="0" disabled>No hay Opciones Disponibles</option>
                            @endforelse
                            </select>                                                         
                            <label for="categoria">Categoria</label>
                            @error('categoria') <span class="error">{{ $message }}</span> @enderror
                        </div>


                        <div class="form-floating mb-3">  
                            <select name="proveedor" id="proveedor" class="form-select 
                            @error('proveedor')
                                is-invalid
                            @enderror
                            " wire:model="proveedor" >
                            <option selected >Seleciona una opción</option>
                            @forelse ($proveedores as $pr)
                                    <option value="{{ $pr->id }}">{{ $pr->nombre }}</option>
                            @empty
                            <option value="0" disabled>No hay Opciones Disponibles</option>
                            @endforelse
                            </select>                                                         
                            <label for="proveedor">Proveedor</label>
                            @error('proveedor') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer col-12">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar <i
                            class="material-icons-two-tone text-white">close</i></button>
                    <button type="submit" class="btn  btn-primary" form="productoForm">
                        @if ($id_producto)
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
            let modal = document.getElementById('productoModal');
    
            modal.addEventListener('hide.bs.modal',function(){
                Livewire.emit('resetNamesProductos');
            }) ;
    
            window.addEventListener('closeModal', event => {
            $("#productoModal").modal('hide');  
              
              
            });
    
         
    
        </script>
    @endpush
    
    
</div>
