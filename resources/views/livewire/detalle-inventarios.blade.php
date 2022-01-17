<div>
    <div>
        <div id="detalleInventarioModal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="detalleInventarioModalTitle" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title col-11 text-center" id="detalleInventarioModalLabel">

                            Agregar Detalla de Inventario
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="createDetalleInventario" id="detalleInventarioForm">
                            <!--CONCEPTO-->
                            <div class="form-floating mb-3">

                                <textarea name="concepto" id="concepto" cols="10" rows="3" placeholder="Concepto"
                                    wire:model="concepto" class="form-control                           
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
                        " id="precio_unitario" placeholder="Precio Unitario" wire:model="precio_unitario">
                                <label for="precio_unitario">Precio Unitario</label>
                                @error('precio_unitario') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!--SELECT de origen-->
                            <div class="form-floating mb-3">
                                <select class="form-select  @error('origen')
                            is-invalid
                        @enderror
                        " wire:model="origen" aria-label="Selecione el Origen">
                                    <option selected>Selecione el Origen</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Salida">Salida</option>

                                </select>

                                <label for="origen">Seleción del Origen</label>

                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select  @error('tipo_documento')
                            is-invalid
                        @enderror
                        " wire:model="tipo_documento" aria-label="Selecione el Origen">
                                    <option selected>Selecione el tipo de documento</option>
                                    @foreach ($tipos as $t)
                                    <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                                    @endforeach

                                </select>

                                <label for="cantidad_entrada">Seleción del tipo de documento</label>

                            </div>
                            <!--Documento-->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control 
                        @error('factura')
                            is-invalid
                        @enderror
                        " id="factura" placeholder="No de Documento" wire:model="factura">
                                <label for="factura">No de Documento</label>
                                @error('factura') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            @if ($origen == 'Entrada')

                            <!--Documento Proveedor-->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control 
                        @error('factura_proveedor')
                            is-invalid
                        @enderror
                        " id="factura_proveedor" placeholder="No de Documento" wire:model="factura_proveedor">
                                <label for="factura_proveedor">No de Documento del Proveedor</label>
                                @error('factura_proveedor') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            @endif

                            <!--CANTIDAD ENTRADA-->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control 
                        @error('cantidad')
                            is-invalid
                        @enderror
                        " id="cantidad" placeholder="Cantidad" wire:model="cantidad">
                                <label for="cantidad">Cantidad</label>
                                @error('cantidad') <span class="error">{{ $message }}</span> @enderror
                            </div>



                            <!--FECHA REGISTRO-->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control 
                        @error('fecha_registro')
                            is-invalid
                        @enderror
                        " id="fecha_registro" placeholder="Selecione la fecha" wire:model="fecha_registro">
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

                            <i class="material-icons-two-tone text-white">save</i></button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        let modalDetalles = document.getElementById('detalleInventarioModal');
    
            modalDetalles.addEventListener('hide.bs.modal',function(){
                Livewire.emit('resetNamesDetalleInventarios');
            }) ;
    
            window.addEventListener('closeModal', event => {
            $("#detalleInventarioModal").modal('hide');  
              
              
            });
    
         
    
    </script>
    @endpush


</div>