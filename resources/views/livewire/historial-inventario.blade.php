<div>

    @foreach ($detalle as $key => $d)
    <div wire:ignore.self>
        <div class="modal fade" id="modalFactura{{ $key }}" aria-hidden="true" aria-labelledby="modalFacturaLabel"
            tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title col-11 text-center" id="modalFacturaLabel">Detalle de Factura
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-start">Concepto</th>
                                    <th scope="col" class="text-start">No Factura</th>
                                    <th scope="col" class="text-start">No Factura Proveedor</th>
                                    <th scope="col" class="text-end">Promedio Ponderado</th>
                                    <th scope="col" class="text-end">Precio Proveedor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start">{{ $d->concepto }}</td>
                                    <td class="text-start">{{ $d->factura }}</td>
                                    <td class="text-start">
                                        @if ($d->factura_proveedor == null)

                                        @else
                                        {{ $d->factura_proveedor }}
                                        @endif

                                    </td>
                                    <td class="text-end">$ {{ $d->precio_unitario }}</td>
                                    <td class="text-end">
                                        @if ($d->precio_unitario_proveedor == null)
                                        @else
                                        $ {{ $d->precio_unitario_proveedor }}
                                        @endif

                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-toggle="modal" data-dismiss="modal"
                            data-target="#historialModal">Regresar al Detalle</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

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
                            <table class="table table-bordered border-dark">
                                <thead>
                                    @foreach ($inventarios as $i)
                                    <tr>
                                        <th scope="col">Producto:
                                            <br>
                                            {{ $i->producto }}
                                        </th>
                                        <th scope="col">Codigo del Producto:
                                            <br>
                                            {{ $i->cod_producto }}
                                        </th>
                                        <th scope="col">Ubicacion:
                                            <br>
                                            {{ $i->almacen }}
                                            <br>
                                            Zona:
                                            <br>
                                            {{ $i->zona_almacen }}
                                        </th>
                                        <th scope="col">Proveedor:
                                            <br>
                                            {{ $i->proveedor }}
                                        </th>

                                    </tr>
                                    <tr>
                                        <th scope="col">Cantidad Minima:
                                            <br>
                                            {{ $i->cantidad_min }}
                                        </th>
                                        <th scope="col">Cantidad Maxima:
                                            <br>
                                            {{ $i->cantidad_max }}
                                        </th>


                                    </tr>
                                    @endforeach

                                </thead>
                            </table>
                            <br>

                            <table class="table table-bordered border-dark">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col" rowspan="0.5" class="text-center">Fecha</th>
                                        <th scope="col" colspan="3" class="text-center">Detalle</th>
                                        <th scope="col" colspan="2" class="text-center">Entradas</th>
                                        <th scope="col" colspan="2" class="text-center">Salidas</th>
                                        <th scope="col" colspan="2" class="text-center">Saldos</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">CONCEPTO</th>
                                        <th scope="col">DOC</th>
                                        <th scope="col">PRECIO UNITARIO</th>


                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">TOTAL</th>

                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">TOTAL</th>

                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">TOTAL</th>
                                    </tr>

                                </thead>
                                <tbody class="text-center">
                                    @if (sizeof($detalle) == 0)
                                    <tr>

                                        <td class="text-center fs-1" colspan="12">No hay datos para este inventario</td>
                                    </tr>

                                    @else
                                    @foreach ($detalle as $key => $d)

                                    <tr>
                                        <td>{{ $d->fecha_registro }}</td>
                                        <td scope="col" colspan="1">
                                            {{ $d->concepto }}
                                        </td>
                                        @if ($d->origen == 1 || $d->origen == 2)
                                            <td>

                                            </td>
                                        @else
                                        <td scope="col" colspan="1">
                                            <button class="btn" data-target="#modalFactura{{ $key }}"
                                                data-toggle="modal" data-dismiss="modal">No: {{ $d->factura }}</button>
                                        </td>
                                        @endif
                                        
                                        <td>$ {{ number_format($d->precio_unitario,2) }}</td>

                                        @if ($d->origen == 1)
                                        <td class="text-danger">
                                            @if ($d->cantidad_entrada == null)

                                            @else
                                            ( {{ $d->cantidad_entrada }})
                                            @endif
                                        </td>
                                        @else
                                        <td> @if ($d->cantidad_entrada == null)

                                            @else
                                            {{ $d->cantidad_entrada }}
                                            @endif
                                        </td>
                                        @endif




                                        @if ($d->origen == 1)
                                        <td class="text-danger">
                                            @if ($d->total_entrada == null)

                                            @else
                                            ($ {{ number_format($d->total_entrada,2) }})
                                            @endif
                                        </td>
                                        @else
                                        <td>
                                            @if ($d->total_entrada == null)

                                            @else
                                            $ {{ number_format($d->total_entrada,2) }}
                                            @endif
                                        </td>
                                        @endif
                                        
                                        @if ($d->origen == 2)
                                        <td class="text-danger">
                                            @if ($d->cantidad_salida == null)

                                            @else
                                            ({{ $d->cantidad_salida }})
                                            @endif


                                        </td>
                                        @else
                                        <td>
                                            @if ($d->cantidad_salida == null)

                                            @else
                                            {{ $d->cantidad_salida }}
                                            @endif


                                        </td>
                                        @endif

                                       
                                        @if ($d->origen == 2)
                                        <td class="text-danger">
                                            @if ($d->total_salida == null)

                                            @else
                                            $ ({{ number_format($d->total_salida,2) }})
                                            @endif

                                        </td>
                                        @else
                                        <td>
                                            @if ($d->total_salida == null)

                                            @else
                                            $ {{ number_format($d->total_salida,2) }}
                                            @endif

                                        </td>
                                        @endif
                                       
                                        <td>{{ $d->cantidad_saldo }}</td>

                                        <td>$ {{ number_format($d->total_saldo,2) }}</td>
                                    </tr>
                                    @endforeach
                                    @endif



                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer col-12">

                        <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
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
            });
    
            window.addEventListener('closeModal', event => {
            $("#historialModal").modal('hide');              
            });

            
        
            
         
            
    </script>
    @endpush


</div>