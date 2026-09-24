@extends("layouts.auth")

@section('title')
Registrarme
@endsection

@section('auth-contents')
<form action="{{ route('register.store') }}" method="POST" class="mt-8 space-y-5" novalidate>
    @csrf

    <!-- Name -->
    <div class="space-y-2">
        <label class="form-label" for="name">Nombre</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Tu Nombre"
            class="form-input @error('name') border-red-500 @enderror" required autofocus autocomplete="name"
            tabindex="1" />
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <!-- Email -->
    <div class="space-y-2">
        <label class="form-label" for="email">Correo Electrónico</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email de Registro"
            class="form-input @error('email') border-red-500 @enderror" required autocomplete="email" tabindex="2" />
        <x-input-error :messages="$errors->get('email')" />
    </div>

    <!-- Password -->
    <div class="space-y-2">
        <label class="form-label" for="password">Contraseña</label>
        <input id="password" type="password" name="password" placeholder="Password de Registro"
            class="form-input @error('password') border-red-500 @enderror" required autocomplete="new-password"
            tabindex="3" />
        <x-input-error :messages="$errors->get('password')" />
    </div>

    <!-- Password Confirmation -->
    <div class="space-y-2">
        <label class="form-label" for="password_confirmation">Repetir Contraseña</label>
        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repite tu Password"
            class="form-input @error('password') border-red-500 @enderror" required autocomplete="new-password"
            tabindex="4" />
    </div>

    <!-- Submit Button -->
    <input type="submit" value="Registrarme" class="btn-primary" tabindex="5" />
</form>
@endsection