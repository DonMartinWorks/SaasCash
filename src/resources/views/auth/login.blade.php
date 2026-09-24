@extends("layouts.auth")

@section('title')
Registrarme
@endsection

@section('auth-contents')
<form action="{{ route('login.store') }}" method="POST" class="mt-8 space-y-6" novalidate>
    @csrf

    <!-- Email -->
    <div class="space-y-2">
        <label class="form-label" for="email">Correo Electrónico</label>

        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email de Registro"
            class="form-input @error('email') border-red-500 @enderror" required autofocus autocomplete="username"
            tabindex="1" />

        <x-input-error :messages="$errors->get('email')" />
    </div>

    <!-- Password -->
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <label class="form-label" for="password">Contraseña</label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-purple-950 hover:underline"
                tabindex="4">
                ¿Olvidaste tu Contraseña?
            </a>
            @endif
        </div>

        <input id="password" type="password" name="password" placeholder="Password de Registro"
            class="form-input @error('password') border-red-500 @enderror" required autocomplete="current-password"
            tabindex="2" />

        <x-input-error :messages="$errors->get('password')" />
    </div>

    <!-- Remember me -->
    <div class="flex items-center gap-2">
        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
            class="remember-checkbox" tabindex="3" />
        <label for="remember" class="text-gray-700 font-semibold cursor-pointer select-none">
            Recordarme
        </label>
    </div>

    <!-- Submit Button -->
    <input type="submit" value="Iniciar Sesión" class="btn-primary" tabindex="5" />
</form>
@endsection
