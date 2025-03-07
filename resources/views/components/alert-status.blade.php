@props(['type' => 'info', 'message' => ''])

@php
    $colors = [
        'success' => 'bg-green-100 border-green-500 text-green-700',
        'error' => 'bg-red-100 border-red-500 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-500 text-blue-700',
    ];
    $colorClass = $colors[$type] ?? $colors['info'];
@endphp

@if($message)
    <div class="border-l-4 p-4 mb-4 {{ $colorClass }}" role="alert">
        <p>{{ $message }}</p>
    </div>
@endif
