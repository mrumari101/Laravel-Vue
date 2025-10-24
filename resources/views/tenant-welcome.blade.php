<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ tenant('id') }} - School Management System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        @php
            $tenant = tenant();
            $domain = request()->getHost();
            $allDomains = $tenant->domains;
        @endphp

        <div class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 bg-white dark:bg-[#161615] p-4 rounded-lg shadow-lg">
            <h2 class="font-bold text-2xl mb-4">Tenant Information</h2>
            <ul class="space-y-2">
                <li><strong>Tenant ID:</strong> {{ $tenant->id }}</li>
                <li><strong>Current Domain:</strong> {{ $domain }}</li>
                <li><strong>All Domains:</strong>
                    <ul class="pl-4 mt-1">
                        @foreach($allDomains as $d)
                            <li>- {{ $d->domain }}</li>
                        @endforeach
                    </ul>
                </li>
                <li><strong>Database Connection:</strong> {{ config('database.default') }}</li>
                <li><strong>Request Path:</strong> {{ request()->path() }}</li>
            </ul>
        </div>

        <div class="w-full lg:max-w-4xl max-w-[335px] bg-white dark:bg-[#161615] rounded-lg shadow-lg p-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold mb-4">Welcome to {{ $tenant->id }}'s School Portal</h1>
                <p class="text-gray-600 dark:text-gray-400 mb-8">
                    This is your dedicated school management system workspace.
                </p>

                <div class="flex justify-center gap-4">
                    @auth
                        <a href="{{ route('tenant.dashboard') }}" class="bg-[#1b1b18] text-white dark:bg-[#eeeeec] dark:text-[#1C1C1A] px-6 py-2 rounded-lg hover:opacity-90 transition-opacity">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-[#1b1b18] text-white dark:bg-[#eeeeec] dark:text-[#1C1C1A] px-6 py-2 rounded-lg hover:opacity-90 transition-opacity">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="border border-[#1b1b18] dark:border-[#eeeeec] px-6 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
