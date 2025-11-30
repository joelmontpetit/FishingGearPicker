<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FishingGearPicker') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="font-family: var(--font-sans); background: var(--color-neutral-50); color: var(--color-text-primary); margin: 0; padding: 0; line-height: var(--line-height-normal);">
        <div style="min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: var(--spacing-md);">
            <div style="width: 100%; max-width: 440px;">
                <!-- Logo -->
                <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                    <a href="/" style="text-decoration: none; color: var(--color-text-primary); display: inline-block;">
                        <h1 style="font-size: 28px; font-weight: 700; margin: 0; letter-spacing: -0.02em;">FishingGearPicker</h1>
                        <p style="font-size: 14px; color: var(--color-text-tertiary); margin-top: 8px;">Find the Best Fishing Gear</p>
                    </a>
                </div>

                <!-- Card -->
                <div class="card" style="padding: var(--spacing-xl);">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div style="text-align: center; margin-top: var(--spacing-md); font-size: 14px; color: var(--color-text-tertiary);">
                    <p>© {{ date('Y') }} FishingGearPicker. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>
