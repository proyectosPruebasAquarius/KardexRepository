<div>
    <a class="pc-head-link dropdown-toggle arrow-none mr-0 position-relative" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <i data-feather="bell"></i>
        @if($notifications)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ count($notifications) }}
            {{-- 99+ --}}
        <span class="visually-hidden">unread messages</span>
        </span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right pc-h-dropdown dropdown-scroll" style="max-height: 280px; overflow-y: auto; position: relative;">
        <div class=" dropdown-header">
            <h5 class="text-overflow m-0 text-center"><span class="badge bg-light-primary">Notificaciones</span></h5>
        </div>
    
        @forelse ($notifications as $notify)
        @if(isset($notify->data['message_body']['type']))
        <a type="button" class="dropdown-item" {{-- wire:click="redirection(@js($notify->id))" --}} onclick="openModalSoU(@js($notify->data['message_body']['id_pedido']))">
        @else
        <a type="button" class="dropdown-item" wire:click="redirection(@js($notify->id))">
        @endif
            <i class="material-icons-two-tone">mark_email_unread</i>
            <span>{{ $notify->data['message_title'] }}</span>
        </a>
        @empty
            @auth
                <div class="dropdown-item">
                    <span class="text-muted" style="font-size: 12px">{{ __('No se encontraron notificationes') }}</span>
                </div>
            @else
                <div class="dropdrown-item text-center">
                    <span class="text-muted" style="font-size: 12px">{{ __('Debes estar logueado para ver tús notificationes') }}</span>
                </div>
            @endauth
        @endforelse
    </div>

    @push('scripts')
        <script>
            'use strict';

            (function () {
                const ps = new PerfectScrollbar('.dropdown-scroll', {
                    wheelSpeed: .5,
                    swipeEasing: 0,
                    wheelPropagation: 1,    
                    minScrollbarLength: 20
                });
            }())

            let openModalSoU = (id) => {
                Livewire.emit('assignValuePedidos', id);
                var mdlPedidos = new bootstrap.Modal(document.getElementById('pedidosModal'));
                mdlPedidos.show();
            }
        </script>
    @endpush
</div>