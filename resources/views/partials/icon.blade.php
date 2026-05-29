@php($iconClass = $class ?? 'h-5 w-5')

@switch($name)
    @case('search')
        <svg class="{{ $iconClass }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m16.5 16.5 4 4"/></svg>
        @break
    @case('heart')
        <svg class="{{ $iconClass }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.5 5.8c-1.7-2-4.8-1.8-6.4.3L12 8.7 9.9 6.1C8.3 4 5.2 3.8 3.5 5.8c-1.8 2.1-1.4 5.3.8 7.2l7.7 6.6 7.7-6.6c2.2-1.9 2.6-5.1.8-7.2Z"/></svg>
        @break
    @case('bag')
        <svg class="{{ $iconClass }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6.5 8.5h11l1 12h-13l1-12Z"/><path d="M9 8.5V6a3 3 0 0 1 6 0v2.5"/></svg>
        @break
    @case('account')
        <svg class="{{ $iconClass }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 20c1.3-3.6 4-5.5 7.5-5.5s6.2 1.9 7.5 5.5"/></svg>
        @break
    @case('close')
        <svg class="{{ $iconClass }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
        @break
    @case('arrow-right')
        <svg class="{{ $iconClass }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h15"/><path d="m13 6 6 6-6 6"/></svg>
        @break
    @case('arrow-left')
        <svg class="{{ $iconClass }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12H5"/><path d="m11 6-6 6 6 6"/></svg>
        @break
    @case('menu')
        <svg class="{{ $iconClass }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 17h16"/></svg>
        @break
@endswitch
