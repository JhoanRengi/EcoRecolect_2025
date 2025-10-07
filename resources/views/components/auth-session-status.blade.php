@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 mb-4 text-sm text-green-800 bg-green-200 border border-green-500 rounded-lg dark:bg-green-800 dark:text-green-100 dark:border-green-600 shadow-md']) }} role="alert">
        <span class="font-semibold">¡Éxito!</span> {{ $status }}
    </div>
@endif