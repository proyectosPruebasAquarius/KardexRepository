@extends('index')

@section('title', 'Usuarios')

@section('main-content')
    
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Usuarios</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item">Usuarios</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<div class="row">        
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Lista de Usuarios</h4>
                    
                
            <div class="d-flex justify-content-end col-12 mt-3"><button class="btn btn-primary" type="button" class="btn  btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><span class="d-inline">Agregar</span> <i data-feather="plus" class="d-inline"></i></button></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-center" id="table">                    
                    <thead>
                        <tr>
                            <th scope="col">Nombres y Apellidos</th>                           
                            <th scope="col">Correo Electrónico</th>
                            <th scope="col">Fecha de Registro</th>
                            <th scope="col" class="no-sort">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $d)
                        <tr>                            
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->email }}</td>  
                            <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                            <td>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#updateModal" onclick="Livewire.emit('assignUser', @js($d))"><i class="icon feather icon-edit f-16 text-success text-center"></i></button>
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
    @livewire('users')
    @livewire('users-update')
</div>
@endsection

@push('scripts')
<script>
    var myModal = document.getElementById('exampleModalCenter')
    var updateModal = document.getElementById('updateModal')

    updateModal.addEventListener('hide.bs.modal', function () {
        Livewire.emit('resetUserModalU')
    })
    myModal.addEventListener('hide.bs.modal', function () {
        Livewire.emit('resetUserModal')
    })

    Livewire.on('listReload', function () {
        var modal = new bootstrap.Modal(document.getElementById('exampleModalCenter'))
        modal.hide();
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
            cancelButtonText: 'Cancelar',
            }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('dropByState', id)
            }
        })
    }

    /* document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            let th = Array.from(document.querySelectorAll('th')).find(e => e.textContent === 'Acciones')
            if (th.classList.contains('sorting')) {
                th.classList.remove('sorting')
            }
        }, 1000)
    }, false); */
    
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
            /* "order": [], */
            "columnDefs": [ {
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