@props([
    'type' => 'success',
    'message' => null
])

@php
    $message = $message ?? session('status') ?? session('success') ?? session('error') ?? session('warning');

    if (session('error')) {
        $type = 'error';
    } elseif (session('warning')) {
        $type = 'warning';
    } elseif (session('info')) {
        $type = 'info';
    } elseif (session('status')) {
        $type = 'status';
    }

    $styles = [
        'success' => 'bg-green-100 border-green-500 text-green-800',
        'error'   => 'bg-red-100 border-red-500 text-red-800',
        'warning' => 'bg-amber-100 border-amber-500 text-amber-800',
        'info'    => 'bg-blue-100 border-blue-500 text-blue-800',
        'status'  => 'bg-sky-100 border-sky-500 text-sky-800',
    ][$type] ?? 'bg-green-100 border-green-500 text-green-800';
@endphp

@if ($message)
    <div {{ $attributes->merge(['class' => "alert-container my-10 text-center border-l-2 border-r-2 py-3 text-sm font-bold uppercase rounded-xs  {$styles}"]) }}>
        <div class="flex justify-between px-2">
            <div class="flex items-center gap-2">
                <p class="text-sm font-medium normal-case">{{ $message }}</p>
            </div>

            <button onclick="this.closest('.alert-container').remove()" type="button" class="text-gray-500 hover:text-gray-700 ml-4 font-bold text-lg leading-none cursor-pointer">
                &times;
            </button>
        </div>
    </div>
@endif