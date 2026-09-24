@extends("layouts.auth")

@section('title')
Registrarme
@endsection

@section('auth-contents')
<section
    class="my-4">
    <div
        class="w-full max-w-xl bg-white px-8 py-4 rounded-2xl shadow-xl border border-neutral-300 overflow-hidden transition-all">

        <!-- Header -->
        <header class="px-8 pt-8 pb-4 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-neutral-800 uppercase">
                {{ $title ?? 'Saludos' }}
            </h1>
            <div class="mt-1 h-1 w-28 bg-amber-500 mx-auto rounded-full"></div>
        </header>

        <p class="mt-5 text-lg">Tu cuenta ha sido creada exitosamente. Por favor, verifica tu correo electrónico
            para activar tu cuenta.</p>

        @include('components.toast-messages')

        <form action="{{ route('verification.resend') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="btn-primary">
                Reenviar Correo de Verificación
            </button>
        </form>
    </div>
</section>
@endsection