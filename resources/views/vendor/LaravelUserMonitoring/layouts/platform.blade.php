@php
    // Detect platform safely from any monitoring page
    $platform = '';

    if (isset($visit) && isset($visit->platform)) {
        $platform = $visit->platform;
    } elseif (isset($authenticationMonitoring) && isset($authenticationMonitoring->platform)) {
        $platform = $authenticationMonitoring->platform;
    } elseif (isset($action) && isset($action->platform)) {
        $platform = $action->platform;
    }

    $platform = strtolower($platform);
@endphp


{{-- WINDOWS --}}
@if (str_contains($platform, 'windows'))

<svg class="text-gray-800" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" viewBox="0 0 24 24">
    <path fill-rule="evenodd" d="M3.005 12 3 6.408l6.8-.923v6.517H3.005ZM11 5.32 19.997 4v8H11V5.32ZM20.067 13l-.069 8-9.065-1.275L11 13h9.067ZM9.8 19.58l-6.795-.931V13H9.8v6.58Z" clip-rule="evenodd"/>
</svg>


{{-- LINUX --}}
@elseif (str_contains($platform, 'linux'))

<svg width="25" height="25" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
    <circle cx="16" cy="16" r="14" fill="#fff"/>
    <path d="M16 6c-3 0-4 3-4 6 0 2 1 3 1 4s-2 3-2 5c0 2 2 4 5 4s5-2 5-4c0-2-2-4-2-5s1-2 1-4c0-3-1-6-4-6z" fill="#000"/>
</svg>


{{-- MAC --}}
@elseif (str_contains($platform, 'mac') || str_contains($platform, 'darwin'))

<svg width="25" height="25" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
    <path d="M16 2c0 2-2 3-2 3s-1-2 1-3c1-1 1 0 1 0zM12 5c-4 0-7 3-7 7 0 3 2 7 5 7 1 0 2-1 3-1s2 1 3 1c3 0 5-4 5-7 0-4-3-7-7-7z"/>
</svg>


{{-- ANDROID --}}
@elseif (str_contains($platform, 'android'))

<svg width="25" height="25" viewBox="0 0 24 24" fill="#3DDC84" xmlns="http://www.w3.org/2000/svg">
    <path d="M17.6 9.48l1.43-2.48a.5.5 0 10-.87-.5l-1.46 2.52A7.957 7.957 0 0012 8c-1.7 0-3.28.53-4.57 1.44L5.97 6.92a.5.5 0 10-.87.5L6.53 9.5A8 8 0 004 15v5h16v-5a8 8 0 00-2.4-5.52z"/>
</svg>


{{-- IOS --}}
@elseif (str_contains($platform, 'ios') || str_contains($platform, 'iphone'))

<svg width="25" height="25" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
    <path d="M16 13c0-3 2-4 2-4s-1-2-3-2c-2 0-3 1-3 1s-1-1-3-1c-3 0-5 3-5 6s2 7 5 7c1 0 2-1 3-1s2 1 3 1c2 0 5-3 5-7z"/>
</svg>


{{-- UNKNOWN --}}
@else

<svg width="25" height="25" viewBox="0 0 24 24" fill="gray" xmlns="http://www.w3.org/2000/svg">
    <circle cx="12" cy="12" r="10"/>
</svg>

@endif