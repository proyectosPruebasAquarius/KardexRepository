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
                            <table class="table table-bordered border-dark" >
                                <thead >
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
                                <thead class="text-center" >
                                    <tr>
                                        <th scope="col" rowspan="0.5" class="text-center">Fecha</th>
                                        <th scope="col" colspan="2" class="text-center">Detalle</th>
                                        <th scope="col" colspan="3" class="text-center">Entradas</th>
                                        <th scope="col" colspan="3" class="text-center">Salidas</th>
                                        <th scope="col" colspan="3" class="text-center">Saldos</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">CONCEPTO</th>
                                        <th scope="col">DOC</th>
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">VR. UNITARIO</th>
                                        <th scope="col">VR. TOTAL</th>

                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">VR. UNITARIO</th>
                                        <th scope="col">VR. TOTAL</th>
                                        
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">VR. UNITARIO</th>
                                        <th scope="col">VR. TOTAL</th>
                                    </tr>
                                    <!--<tr>
                                        <th colspan="">Fecha</th>
                                        
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Precio Unitario</th>
                                        <th scope="col">Cantidad de entrada</th>
                                        <th scope="col">Total de Entrada</th>
                                        <th scope="col">Cantidad de Salida</th>
                                        <th scope="col">Total de Salida</th>
                                        <th scope="col">Cantidad de Saldo</th>
                                        <th scope="col">Total de Saldo</th>
                                    </tr>-->
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
                                        <td scope="col" colspan="1">{{ $d->concepto }}</td>
                                        <td scope="col" colspan="1">
                                            Tipo: {{ $d->tipo_documento }}   
                                            <br>                                             
                                            No: {{ $d->factura }}
                                            @if ($d->cantidad_entrada !== null)
                                            <br>
                                            No Pro: {{ $d->factura_proveedor }}
                                            @else

                                            @endif
                                            
                                        
                                        </td>
                                        <td>
                                            @if ($d->cantidad_entrada == null)
                                           
                                            @else
                                            {{ $d->cantidad_entrada }}
                                            @endif

                                        </td>
                                      
                                        <td>
                                            @if ($d->total_entrada == null)

                                            @else
                                            $ {{ $d->precio_unitario }}
                                            @endif    
                                            
                                            
                                        </td>
                                        <td>
                                            @if ($d->total_entrada == null)
                                            
                                            @else
                                            $ {{ $d->total_entrada }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($d->cantidad_salida == null)
                                           
                                            @else
                                            {{ $d->cantidad_salida }}
                                            @endif


                                        </td>
                                        <td> @if ($d->total_salida == null)

                                            @else
                                            $ {{ $d->precio_unitario }}
                                            @endif  </td>
                                        <td>
                                            @if ($d->total_salida == null)
                                           
                                            @else
                                            $ {{ $d->total_salida }}
                                            @endif

                                        </td>
                                        <td>{{ $d->cantidad_saldo }}</td>
                                        <td>$ {{ $d->precio_unitario }}</td>
                                        <td>$ {{ $d->total_saldo }}</td>
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
            }) ;
    
            window.addEventListener('closeModal', event => {
            $("#historialModal").modal('hide');  
              
              
            });
    
         
    
    </script>
    @endpush


</div>