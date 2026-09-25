@extends('layouts.base')

@section('contents')
<main class="max-w-2xl mt-10 mx-auto p-10 border border-neutral-300 shadow-lg bg-white rounded-sm">
    <h1 class="text-4xl font-bold">@yield('title')</h1>
    @yield('auth-contents')
</main>
@endsection
