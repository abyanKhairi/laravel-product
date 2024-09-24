<a {{ $attributes }} wire:navigate
    class="{{ request()->fullUrlIs(url($href)) ? 'bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium' : 'rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white' }}">{{ $slot }}</a>
