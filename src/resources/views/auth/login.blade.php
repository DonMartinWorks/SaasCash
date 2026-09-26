@extends("layouts.auth")

@section('title')
Iniciar Sesión
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
        <label class="form-label" for="password">Contraseña</label>
        <input id="password" type="password" name="password" placeholder="Password de Registro"
            class="form-input @error('password') border-red-500 @enderror" required autocomplete="current-password"
            tabindex="2" />

        <x-input-error :messages="$errors->get('password')" />
    </div>

    <!-- Remember me & Password Reset -->
    <div
        class="flex items-start flex-wrap gap-2 bg-neutral-50 px-4 py-2.5 rounded-md border border-neutral-200 shadow-lg">
        <label class="flex items-center group has-[input:checked]:text-neutral-900 cursor-pointer">
            <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} tabindex="3"
                class="sr-only" />

            <!-- Custom box -->
            <span class="flex h-4 w-4 shrink-0 items-center justify-center rounded outline-1 outline-neutral-300
                         bg-white
                         group-has-[input:checked]:bg-amber-500
                         group-has-[input:checked]:outline-amber-500
                        group-focus-within:outline-2
                         group-focus-within:outline-amber-500" aria-hidden="true">
                <!-- Checkmark -->
                <svg class="size-3 text-white opacity-0 group-has-[input:checked]:opacity-100" viewBox="0 0 12 10"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 5l3 3 7-7" />
                </svg>
            </span>
            <span class="ml-3 text-sm text-neutral-700 select-none">
                Recordarme
            </span>
        </label>

        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" tabindex="4"
            class="ml-auto transition-all text-sm font-semibold text-neutral-500 hover:underline hover:underline-offset-2 hover:text-amber-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 rounded">
            ¿Olvidaste tu Contraseña?
        </a>
        @endif
    </div>

    <!-- Submit Button -->
    <input type="submit" value="Iniciar Sesión" class="btn-primary" tabindex="5" />
</form>
@endsection
