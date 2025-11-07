@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-secondary-800 border-secondary-700 text-white focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm']) }}>
