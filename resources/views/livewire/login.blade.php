<div>
    <div class="card">
        <div class="row align-items-center text-center">
            <div class="col-md-12">
                <div class="card-body">
                    {{-- <img src="assets/images/logo-dark.svg" alt="" class="img-fluid mb-4"> --}}
                    <div class="mb-4"><h2><a href="{{ url('/') }}">Kardex</a></h2></div>
                    <h4 class="mb-3 f-w-400">Iniciar Sesión</h4>
                    <form wire:submit.prevent="login">
                        @csrf
                        <div class="input-group mb-3">
                            {{-- <span class="input-group-text"><i data-feather="mail"></i></span> --}}
                            <input wire:model.lazy="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo Electrónico" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-4">
                            {{-- <span class="input-group-text"><i data-feather="lock"></i></span> --}}
                            <input type="{{ $checked ? 'text' : 'password' }}" class="form-control
                            @error('password')
                            is-invalid
                            @enderror
                            " placeholder="Contraseña" wire:model.lazy="password" autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            
                        </div>
                        <div class="form-check text-left">
                            <input class="form-check-input" type="checkbox" value="" id="showPassword" wire:click="$toggle('checked')" {{ $checked ? 'checked' : '' }}>
                            <label class="form-check-label" for="showPassword">
                                Ver contraseña
                            </label>
                        </div>
                        <div class="form-group text-left mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Guardar credenciales
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary mb-4">Iniciar Sesión</button>
                    </form>
                    <p><a href="{{ url('/') }}">Volver a inicio</a></p>
                    {{-- <p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html" class="f-w-400">Signup</a></p> --}}
                </div>
            </div>
        </div>
    </div>    
</div>