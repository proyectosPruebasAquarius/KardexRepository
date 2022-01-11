<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Lista de Proveedores</h4>
                    
                
            <div class="d-flex justify-content-end col-12 mt-3"><button class="btn btn-primary" type="button" class="btn  btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Agregar</button></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-center" id="table">                    
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>                           
                            <th scope="col">Dirección</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $d)
                        <tr>                            
                            <td>{{ $d->nombre }}</td>
                            <td>{{ $d->direccion }}</td> 
                            <td>{{ $d->telefono }}</td>  
                            <td>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModalCenter" wire:click="$emit('assign', {{ $d }})"><i class="icon feather icon-edit f-16 text-success text-center"></i></button>
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

    <!-- Modal -->
    @livewire('proveedores-modal')
</div>

@push('scripts')
<script>    
    var myModal = document.getElementById('exampleModalCenter')
    myModal.addEventListener('hide.bs.modal', function () {
        Livewire.emit('resetDataP')
    })

    Livewire.on('listReloadP', function () {
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
            confirmButtonText: 'Si, borrar'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('dropByStateP', id)            
        }
        })
        /* if (confirm('¿Estas seguro que deseas eliminar el dato?')) {
            
        } */
    }
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
                }
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