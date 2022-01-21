@extends('index')

@section('title', 'Listado de Pedidos - Kardex')

@section('main-content')
    
<!-- [ breadcrumb ] start -->
<div class="page-header 
@if (session()->exists('expandedSide'))
    @if (session('expandedSide'))
    expand-with-items
    @endif
@endif
">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Pedidos</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item">Pedidos</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<div class="row">        
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Lista de Pedidos</h4>
                    
                
            {{-- <div class="d-flex justify-content-end col-12 mt-3"><button class="btn btn-primary" type="button" class="btn  btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Agregar <i data-feather="plus"></i></button></div> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table">                    
                    <thead>
                        <tr>
                            <th scope="col" class="text-start">Código</th>
                            <th scope="col" class="text-start">Producto</th>                           
                            <th scope="col" class="text-center">Precio</th>
                            <th scope="col" class="text-center">Cantidad</th>
                            <th scope="col" class="text-start">Proveedor</th>
                            <th scope="col" class="text-start">Teléfono Proveedor</th>
                            <th scope="col" class="text-start">Estado</th>
                            <th scope="col" class="no-sort text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $d)                       
                        <tr >
                            <td class="text-start">{{ $d->cod_producto }}</td>                            
                            <td class="text-start">{{ $d->nombre }}</td>
                            <td class="text-center">{{ $d->precio }}</td>
                            <td class="text-center">{{ $d->cantidad }}</td>
                            <td class="text-start">
                                {{ $d->proveedor }}
                            </td> 
                            <td class="text-center">
                                {{ $d->telefono }}
                            </td> 
                            @if ($d->estado == 1)
                                <td class="text-start"><span class="badge rounded-pill bg-warning text-dark" style="cursor: pointer" ondblclick="Livewire.emit('edidStateM', @js($d->id), @js($d->estado)); new bootstrap.Modal(document.getElementById('pedidosModal')).show();" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para editar">{{ __('Pendiente') }}</span></td>
                            @elseif($d->estado == 2)
                                <td class="text-start"><span class="badge rounded-pill bg-success" style="cursor: pointer" ondblclick="Livewire.emit('edidStateM', @js($d->id), @js($d->estado)); new bootstrap.Modal(document.getElementById('pedidosModal')).show();" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para editar">{{ __('Finalizado') }}</span></td>
                            @else
                                <td class="text-start"><span class="badge rounded-pill bg-danger" style="cursor: pointer" ondblclick="Livewire.emit('edidStateM', @js($d->id), @js($d->estado)); new bootstrap.Modal(document.getElementById('pedidosModal')).show();" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para editar">{{ __('No enviado') }}</span></td>
                            @endif
                            <td class="text-center">
                                {{-- La funcion llamada aqui, se encuentra en Notifications Livewire --}}
                                <button type="button" class="btn btn-default" onclick="openModalSoU(@js($d->id))" ><i class="icon feather icon-edit f-16 text-success text-center"></i></button>
                                <button type="button" class="btn btn-default" onclick="trash(@js($d->id))"><i class="feather icon-trash-2 ml-3 f-16 text-danger text-center"></i></button>
                            </td>                          
                        </tr>   
                        @empty
                            
                        @endforelse                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let trash = (id) => {
        Swal.fire({
            title: '¿Estás seguro que deseas eliminar este dato?',
            text: "¡Está acción es irreversible!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('destroyPdido', id)
            }
        })
    }
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>


@endpush

@push('datatable-scripts')
    <script>
       $(document).ready( function () {
    $('#table').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                },
                "columnDefs": [{
                    "targets"  : 'no-sort',
                    "orderable": false,
                }]
            });
} );
    </script>

@endpush

@push('partial-style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<style>
    .dataTables_wrapper .dataTables_filter input {
        margin-bottom: 10px !important;
    }
</style>
@endpush