<div>
    <div>
        <div id="historialModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="historialModalTitle"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-fullscreen  " role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h1 class="modal-title col-11 text-center" id="historialModalLabel">
                            Detalle de Inventario
                        </h1>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    @foreach ($inventarios as $i)
                                    <tr>
                                        <th scope="col">Producto:
                                            {{ $i->producto }}
                                        </th>
                                        <th scope="col">Codigo del Producto:
                                            {{ $i->cod_producto }}
                                        </th>
                                        <th scope="col">Ubicacion:
                                            {{ $i->almacen }}
                                        </th>
                                        <th scope="col">Proveedor:
                                            {{ $i->proveedor }}
                                        </th>

                                    </tr>
                                    <tr>
                                        <th scope="col">Cantidad Minima:
                                            {{ $i->cantidad_min }}
                                        </th>
                                        <th scope="col">Cantidad Maxima:
                                            {{ $i->cantidad_max }}
                                        </th>

                                    </tr>
                                    @endforeach

                                </thead>
                            </table>
                            <br>

                            <table class="table">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Cantidad de entrada</th>
                                        <th scope="col">Total de Entrada</th>
                                        <th scope="col">Cantidad de Salida</th>
                                        <th scope="col">Total de Salida</th>
                                        <th scope="col">Cantidad de Saldo</th>
                                        <th scope="col">Total de Saldo</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if (sizeof($detalle) == 0)
                                    <tr>
                                       
                                        <td class="text-center fs-1" colspan="12">No hay datos para este inventario</td>
                                    </tr>
                                   
                                    @else
                                    @foreach ($detalle as $d)
                                    <tr>
                                        <td>{{ $d->fecha_registro }}</td>
                                        <td>
                                            @if ($d->cantidad_entrada == null)
                                            sin registro
                                            @else
                                            {{ $d->cantidad_entrada }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($d->total_entrada == null)
                                            sin registro
                                            @else
                                            $ {{ $d->total_entrada }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($d->cantidad_salida == null)
                                            sin registro
                                            @else
                                            {{ $d->cantidad_salida }}
                                            @endif


                                        </td>
                                        <td>
                                            @if ($d->total_salida == null)
                                            sin registro
                                            @else
                                            $ {{ $d->total_salida }}
                                            @endif

                                        </td>
                                        <td>{{ $d->cantidad_saldo }}</td>
                                        <td>$ {{ $d->total_saldo }}</td>
                                    </tr>
                                    @endforeach
                                    @endif



                                </tbody>
                            </table>
                        </div>

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
        let modalDetalle = document.getElementById('historialModal');
    
            modalDetalle.addEventListener('hide.bs.modal',function(){
                Livewire.emit('resetNamesDetalleInventarios');
            }) ;
    
            window.addEventListener('closeModal', event => {
            $("#historialModal").modal('hide');  
              
              
            });
    
         
    
    </script>
    @endpush


</div>