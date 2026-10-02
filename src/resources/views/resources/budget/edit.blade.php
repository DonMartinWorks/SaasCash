@extends('layouts.app')

@section('title')
Editar Presupuesto&#58;&#160;{{ $budget->name }}
@endsection

@section('actions')
<div class="sm:flex sm:items-center mt-10">
    <div class="sm:flex-auto">
        <h1 class="font-bold text-4xl">Editar Presupuesto&#58;&#160;{{ $budget->name }}</h1>
        <p class="mt-2 text-xl text-gray-500">Crear un Presupuesto es sencillo: añade un nombre y cantidad.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        @if (Route::has('dashboard'))
        <a href="{{ route('dashboard') }}"
            class="block bg-amber-500 text-white w-full px-5 py-3 rounded-lg  font-bold  text-xl cursor-pointer text-center">
            Volver a Presupuestos
        </a>
        @endif
    </div>
</div>
@endsection

@section('dashboard-contents')
@if (Route::has('budgets.update'))
<form method="POST" action="{{ route('budgets.update', $budget) }}" class="mt-14 space-y-3 max-w-2xl mx-auto" novalidate>
    @csrf
    @method('PUT')

    <x-budget-form :budget="$budget" />

    <input type="submit" value='Crear Presupuesto'
        class="bg-purple-950 hover:bg-purple-800 w-full p-3 rounded-lg text-white font-bold  text-xl cursor-pointer" />
</form>
@endif
@endsection
