@extends('layouts.base')

@section('contents')
<main class="max-w-2xl mt-10 mx-auto p-10 border border-neutral-300 shadow-lg bg-white rounded-sm">
    <h1 class="text-4xl font-bold">@yield('title')</h1>
    @yield('auth-contents')

    <footer class="px-8 py-5 bg-neutral-10 0 border-t border-neutral-100 flex items-center justify-between text-sm">
        <a href="{{ route('home') }}" class="text-neutral-400">{{ config('app.name', 'Laravel') }}</a>

        @guest
        <div class="flex items-center space-x-3 font-medium">
            @if (Route::has('login'))
            <a href="{{ route('login') }}" class="text-neutral-600 hover:text-amber-500 transition-colors duration-150">
                Iniciar Sesión
            </a>
            @endif

            @if (Route::has('login') || Route::has('register'))
            <span class="text-neutral-300">|</span>
            @endif

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-neutral-600 hover:bg-amber-500 rounded-lg shadow-sm transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                Registrarme
            </a>
            @endif
        </div>
        @endguest
    </footer>
</main>
@endsection