@extends('index')


@section('title','Listado de Inventarios - Kardex')


@section('main-content')
<div>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Inventarios</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item">Inventarios</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">

        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lista de Inventarios</h4>
                    <div class="col-12 d-flex justify-content-end mt-3">


                        <!-- Button trigger modal -->
                        @livewire('inventarios')
                        @livewire('detalle-inventarios')
                        @livewire('historial-inventario')
                        <button type="button" class="btn  btn-primary" data-toggle="modal"
                            data-target="#inventarioModal">Agregar <span class="pc-micon"><i
                                    class="material-icons-two-tone text-white">add</i></span></button>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table" id="table_id">
                        <thead class="" >
                            <tr>
                                <th scope="col" class="text-start">Codigo del Producto</th>
                                <th scope="col" class="text-start">Producto</th>
                                <th scope="col" class="text-start">Proveedor</th>
                                <th scope="col" class="text-start">Almacen</th>
                                <th scope="col" class="text-start">Zona del Almacen</th>
                                <th scope="col" class="text-center">Cantidad Maxima</th>
                                <th scope="col" class="text-center">Cantidad Minima</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach ($inventarios as $i)
                            <tr>
                                <td class="text-start">{{ $i->cod_producto }}</td>
                                <td class="text-start">{{ $i->nombre_producto }}</td>
                                <td class="text-start">{{ $i->proveedor }}</td>
                                <td class="text-start">{{ $i->nombre_almacen }}</td>
                                <td class="text-start">{{ $i->almacen_zona_nombre }}</td>
                                <td class="text-center">{{ $i->max }}</td>
                                <td class="text-center">{{ $i->min }}</td>
                                <td class="text-center">
                                    <a type="button" data-toggle="modal" data-target="#inventarioModal"
                                        onclick="Livewire.emit('asignInventario',@js($i) )"><i
                                            class="icon feather icon-edit f-16 text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></i></a>
                                    <a type="button" onclick="trash(@js($i->id_inventario))"><i class="feather icon-trash-2 ml-3 f-16 text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"></i></a>
                                    <a type="button" data-toggle="modal" data-target="#detalleInventarioModal"
                                    onclick="Livewire.emit('asignDetalleInventario',@js($i) )" ><i class="feather icon-file-plus ml-3 f-16 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar nuevo detalle"></i></a>
                                    <a type="button" data-toggle="modal" data-target="#historialModal"
                                    onclick="Livewire.emit('asignDetalle',@js($i) )" ><i class="feather icon-external-link ml-3 f-16 text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalle de Inventario"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table >
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

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
                Livewire.emit('dropByStateInventario', id)
            }
        })
    }
</script>

@endpush

@push('datatable-scripts')
<script>
    $(document).ready( function () {
       
                $('#table_id').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                },
               
            });        

} );


</script>

@endpush

@push('partial-style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@endpush