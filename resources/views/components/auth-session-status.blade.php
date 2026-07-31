@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-300 bg-green-500/10 border border-green-500/20 rounded-lg px-4 py-2']) }}>
        {{ $status }}
    </div>
@endif
