<div>
    <div>
        <div id="detalleInventarioModal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="detalleInventarioModalTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-11 text-center" id="detalleInventarioModalLabel" > 
                         
                        Agregar Detalla de Inventario
                         </h5>
                    <button type="button" class="btn-close" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createDetalleInventario" id="detalleInventarioForm">
                        <!--CONCEPTO-->
                        <div  class="form-floating mb-3">
                            
                            <textarea name="concepto" id="concepto" cols="10" rows="3"  placeholder="Concepto" wire:model="concepto" class="form-control                           
                             @error('concepto')
                            is-invalid
                             @enderror
                        ">
                        </textarea>
                        <label for="concepto">Concepto</label>
                        @error('concepto') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!--PRECIO UNITARIO-->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control 
                        @error('precio_unitario')
                            is-invalid
                        @enderror
                        " id="precio_unitario" placeholder="Cantidad de Salida" wire:model="precio_unitario">
                            <label for="precio_unitario">Precio Unitario</label>
                            @error('precio_unitario') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!--CANTIDAD ENTRADA-->
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control 
                        @error('cantidad_entrada')
                            is-invalid
                        @enderror
                        " id="cantidad_entrada" placeholder="Cantidad de Entrada" wire:model="cantidad_entrada">
                            <label for="cantidad_entrada">Cantidad de Entrada</label>
                            @error('cantidad_entrada') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!--CANTIDAD SALIDA-->
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control 
                        @error('cantidad_salida')
                            is-invalid
                        @enderror
                        " id="cantidad_salida" placeholder="Cantidad de Salida" wire:model="cantidad_salida">
                            <label for="cantidad_salida">Cantidad de Salida</label>
                            @error('cantidad_salida') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <!--FECHA REGISTRO-->
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control 
                        @error('fecha_registro')
                            is-invalid
                        @enderror
                        " id="fecha_registro" placeholder="Cantidad Maxima" wire:model="fecha_registro">
                            <label for="fecha_registro">Fecha</label>
                            @error('fecha_registro') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-floating mb-3">  

                            <input type="hidden" class="form-control" wire:model="id_inventario">
                        </div>

                       


                       
                    </form>
                </div>
                <div class="modal-footer col-12">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar <i
                            class="material-icons-two-tone text-white">close</i></button>
                    <button type="submit" class="btn  btn-primary" form="detalleInventarioForm">
                        
                        Guardar
                       
                    <i
                            class="material-icons-two-tone text-white">save</i></button>
    
                </div>
            </div>
        </div>
    </div>
    </div>
    @push('scripts')
        <script>
            let modalDetalle = document.getElementById('detalleInventarioModal');
    
            modalDetalle.addEventListener('hide.bs.modal',function(){
                Livewire.emit('resetNamesDetalleInventarios');
            }) ;
    
            window.addEventListener('closeModal', event => {
            $("#detalleInventarioModal").modal('hide');  
              
              
            });
    
         
    
        </script>
    @endpush
    
    
</div>
