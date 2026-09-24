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

            @if (Route::has('dashboard'))
            <a href="{{ route('dashboard') }}"
                class="text-white transition-all font-bold capitalize p-2 hover:underline hover:underline-offset-4 duration-200 hover:decoration-amber-500">
                {{ Auth::user()->name }}
            </a>
            @endif

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline"
                onsubmit="return confirmLogout(event)">
                @csrf
                <button type="submit"
                    class="font-bold cursor-pointer uppercase border-2 border-amber-500 px-5 py-2 text-amber-500 hover:bg-amber-500 hover:text-purple-950 transition-colors duration-200">
                    Cerrar Sesión
                </button>
            </form>

            @endguest
        </nav>
    </div>
</header>

<script>
    function confirmLogout(event) {
        if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>