<div>
    <!-- Modal -->
    <div class="modal fade" id="pedidosModal" tabindex="-1" aria-labelledby="pedidosModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pedidosModalLabel">{{ $isState ? 'Estado del ' : 'Realizar ' }}Pedido</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent="createElement" id="pFModal">
                        @if($isState)
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <select class="form-control
                                        @error('estado')
                                            is-invalid
                                        @enderror
                                        " id="stateSelect" wire:model="estado">
                                        <option value="1">Pendiente</option>
                                        <option value="2">Finalizado</option>
                                        </select>
                                        <label for="stateSelect">estado</label>
                                        @error('estado') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        @else
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control
                                    @error('producto')
                                        is-invalid
                                    @enderror
                                    " id="nameInput" placeholder="product name" wire:model="producto" readonly>
                                    <label for="nameInput">Producto</label>
                                    @error('producto') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control
                                    @error('cod_producto')
                                        is-invalid
                                    @enderror
                                    " id="codInput" placeholder="product name" wire:model="cod_producto" readonly>
                                    <label for="codInput">Código de Producto</label>
                                    @error('cod_producto') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control
                                    @error('precio')
                                        is-invalid
                                    @enderror
                                    " id="priceInput" placeholder="$00.00" wire:model="precio">
                                    <label for="priceInput">Precio $</label>
                                    @error('precio') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control
                                    @error('cantidad')
                                        is-invalid
                                    @enderror
                                    " id="quatintyInput" placeholder="12" wire:model="cantidad">
                                    <label for="quatintyInput">Cantidad</label>
                                    @error('cantidad') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-center">Datos del proveedor</h5>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control
                                    @error('proveedor')
                                        is-invalid
                                    @enderror
                                    " id="prvInput" placeholder="product name" wire:model="proveedor" readonly>
                                    <label for="prvInput">Proveedor</label>
                                    @error('proveedor') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control
                                    @error('proveedor_tel')
                                        is-invalid
                                    @enderror
                                    " id="prvTInput" placeholder="product name" wire:model="proveedor_tel" readonly>
                                    <label for="prvTInput">Teléfono</label>
                                    @error('proveedor_tel') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </form>
                    {{-- <div class="row">
                        <div class="col">
                            <a type="button" class="buttonD" href="{{ route('pedidos') }}">Ir a lista de pedidos</a>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="pFModal">Guardar Pedido</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            'use strict';

            window.addEventListener('closeModal', function() {
                $("#pedidosModal").modal('hide'); 
            });

            document.getElementById('pedidosModal').addEventListener('hide.bs.modal', function() {
                Livewire.emit('resetVFPedidos');
            });

            

            function dragElement(elmnt) {
                var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0, modalDr = document.getElementById(elmnt.id);
                if (modalDr.querySelector('.modal-header')) {
                    /* if present, the header is where you move the DIV from:*/
                    modalDr.querySelector('.modal-header').onmousedown = dragMouseDown;
                } else {
                    /* otherwise, move the DIV from anywhere inside the DIV:*/
                    elmnt.onmousedown = dragMouseDown;
                }

                function dragMouseDown(e) {
                    e = e || window.event;
                    e.preventDefault();
                    // get the mouse cursor position at startup:
                    pos3 = e.clientX;
                    pos4 = e.clientY;
                    document.onmouseup = closeDragElement;
                    // call a function whenever the cursor moves:
                    document.onmousemove = elementDrag;
                }

                function elementDrag(e) {
                    e = e || window.event;
                    e.preventDefault();
                    // calculate the new cursor position:
                    pos1 = pos3 - e.clientX;
                    pos2 = pos4 - e.clientY;
                    pos3 = e.clientX;
                    pos4 = e.clientY;
                    // set the element's new position:
                    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
                }

                function closeDragElement() {
                    /* stop moving when mouse button is released:*/
                    document.onmouseup = null;
                    document.onmousemove = null;
                }
            }

            document.getElementById('pedidosModal').addEventListener('show.bs.modal', function(e) {
                dragElement(e.target);
            });
        </script>
    @endpush
</div>

