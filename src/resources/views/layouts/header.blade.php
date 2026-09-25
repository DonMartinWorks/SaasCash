<!-- Header -->
<header class="bg-purple-950 py-5">
    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center lg:justify-between px-4">
        <div class="w-full max-w-100">
            <a href="{{ route('home') }}" class="w-full max-w-100">
                <img src="{{ asset('files/img/logo.svg') }}" alt="{{ config('app.name', 'Laravel') }}"
                    class="w-full block hover:opacity-90">
            </a>
        </div>

        <nav class="flex flex-col lg:flex-row items-center gap-4">
            @guest

            @if (Route::has('login'))
            <a href="{{ route('login') }}" class="text-white font-bold uppercase p-2">
                Iniciar Sesión
            </a>
            @endif

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="font-bold uppercase border-2 border-amber-500 px-5 py-2 text-amber-500">
                Registrarme
            </a>
            @endif

            @else
            <p class="text-white text-xl font-semibold underline underline-offset-4 decoration-amber-500 decoration-2">
                {{ Auth::user()->name }}
            </p>

            <x-dropdown-menu />
            @endguest
        </nav>
    </div>
</header>