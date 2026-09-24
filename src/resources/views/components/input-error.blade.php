@props(['messages'])

@if (!empty($messages))
<ul {{ $attributes->merge(['class' => 'input-error']) }}>
    @foreach ((array) $messages as $message)
    <li>{{ $message }}</li>
    @endforeach
</ul>
@endif