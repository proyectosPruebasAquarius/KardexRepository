<div>
    <form class="px-3">
        <div class="form-group mb-0 d-flex align-items-center">
            <i data-feather="search"></i>
            <input type="search" class="form-control border-0 shadow-none" placeholder="Buscar. . ." wire:model="search" @if($isKeyWord)
                style="padding-left: 85px"
            @endif>
            @if($isKeyWord)
            <label class="label badge bg-danger" style="position: absolute;
            left: 30px;;">{{ $keyWord }}</label>
            @endif
        </div>
    </form>    
    @if($search)
    <ol class="list-group list-group-numbered">
        @forelse ($users as $u)
        @if($loop->first)
        <li class="list-group-item  text-center border-top-0">
            <div class="text-center">
                <span class="badge bg-primary">
                    Usuarios
                </span>
                <span class="badge bg-primary rounded-pill">{{ count($users) }}</span>
            </div>
            
          
        </li>
        @endif
        <li class="list-group-item d-flex justify-content-between align-items-start border-top-0">
            <div class="ms-2 me-auto">
              <div class="fw-bold">{{ $u->name }}</div>
              {{ $u->email }}
            </div>
            <span class="badge bg-primary rounded-pill">14</span>
        </li>
        @empty
            
        @endforelse
        @forelse ($almacenes as $a)
        @if($loop->first)
        <li class="list-group-item  text-center border-top-0">
            <div class="text-center">
                <span class="badge bg-secondary">
                    Almacenes
                </span>
                <span class="badge bg-primary rounded-pill">{{ count($almacenes) }}</span>
            </div>
            
          
        </li>
        @endif
        <li class="list-group-item d-flex justify-content-between align-items-start border-top-0">
            <div class="ms-2 me-auto">
              <div class="fw-bold">{{ $a->nombre }}</div>
              {{ $a->direccion }}
            </div>
            <span class="badge bg-primary rounded-pill">14</span>
        </li>
        @empty
            
        @endforelse        
    </ol>  
    @endif
</div>
