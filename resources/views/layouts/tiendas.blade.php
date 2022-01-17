@extends('index')

@section('title', 'Tiendas')

@section('main-content')
    
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tiendas</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item">Tiendas</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<div class="row">        
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Lista de Tiendas</h4>
                    
                
            <div class="d-flex justify-content-end col-12 mt-3"><button class="btn btn-primary" type="button" class="btn  btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Agregar <i data-feather="plus"></i></button></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-center" id="table">                    
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>                           
                            <th scope="col">Direccion</th>
                            <th scope="col">Almacen</th>
                            <th scope="col" class="no-sort">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tiendas as $d)
                        <tr class="text-left">                            
                            <td>{{ $d->nombre }}</td>
                            <td>
                                {{ $d->direccion }}
                            </td>  
                            <td>
                                {{ $d->almacen }}
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModalCenter" onclick="Livewire.emit('assignTi', @js($d))"><i class="icon feather icon-edit f-16 text-success text-center"></i></button>
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
    @livewire('tiendas')
</div>
@endsection

@push('scripts')
<script>
    var myModal = document.getElementById('exampleModalCenter')
    myModal.addEventListener('hide.bs.modal', function () {
        Livewire.emit('resetDataTi')
    })   

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
                Livewire.emit('deleteTienda', id)
            }
        })
    }

    window.addEventListener('close-modal', event => {
        $("#exampleModalCenter").modal('hide');     
    });
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

{{-- let function open() {
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
    myModal.show();
} --}}
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