@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-gray-900 focus:ring-blue-300 rounded-xl shadow-sm']) }}>