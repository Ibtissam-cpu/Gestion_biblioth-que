<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-blue-800 text-white">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <a href="{{ route('client.dashboard') }}" class="text-xl font-bold">Biblio</a>
                    </div>
                    <div class="flex space-x-4 items-center">
                        <a href="#" class="hover:text-blue-200">Catalogue</a>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center focus:outline-none">
                                {{ Auth::user()->name }}
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('client.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar + Content -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div class="bg-white w-64 shadow hidden md:block">
                <div class="py-4">
                    <ul>
                        <li>
                            <a href="{{ route('client.dashboard') }}" class="block py-2 px-4 text-gray-900 hover:bg-blue-50 {{ request()->routeIs('client.dashboard') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : '' }}">
                                Tableau de bord
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('client.loans') }}" class="block py-2 px-4 text-gray-900 hover:bg-blue-50 {{ request()->routeIs('client.loans') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : '' }}">
                                Mes emprunts
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('client.reservations') }}" class="block py-2 px-4 text-gray-900 hover:bg-blue-50 {{ request()->routeIs('client.reservations') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : '' }}">
                                Mes réservations
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block py-2 px-4 text-gray-900 hover:bg-blue-50">
                                Suggestions de lecture
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block py-2 px-4 text-gray-900 hover:bg-blue-50">
                                Amendes et paiements
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t mt-8 py-4">
            <div class="container mx-auto px-4">
                <div class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
