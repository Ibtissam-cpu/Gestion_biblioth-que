<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BiblioGest') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        <div x-cloak :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

        <div x-cloak :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-blue-800 lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <i class="text-white fas fa-book-reader text-2xl"></i>
                    <span class="mx-2 text-2xl font-semibold text-white">BiblioGest</span>
                </div>
            </div>

            <nav class="mt-10">
                <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-blue-700" href="{{ route('membre.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="mx-3">Tableau de bord</span>
                </a>

                <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-blue-700" href="{{ route('membre.recommandations.index') }}">
                    <i class="fas fa-book"></i>
                    <span class="mx-3">Recommandations</span>
                </a>

                <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-blue-700" href="{{ route('historique.index') }}">
                    <i class="fas fa-history"></i>
                    <span class="mx-3">Historique</span>
                </a>
            </nav>
        </div>

        <div class="flex flex-col flex-1 lg:pl-64">
            <!-- Top Navigation -->
            <div class="flex justify-between items-center py-4 px-6 bg-white border-b">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="flex items-center">
                    <div class="relative" x-data="{ notificationOpen: false }">
                        <button @click="notificationOpen = !notificationOpen" class="flex mx-4 text-gray-600 focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </button>

                        <div x-show="notificationOpen" @click.away="notificationOpen = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-50">
                            <div class="py-2">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <a href="#" class="flex items-center px-4 py-3 border-b hover:bg-gray-100">
                                        <p class="text-gray-600 text-sm mx-2">
                                            {{ $notification->data['message'] }}
                                        </p>
                                    </a>
                                @empty
                                    <p class="text-gray-600 text-sm px-4 py-3">Aucune notification</p>
                                @endforelse
                            </div>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-medium text-gray-700 py-2 hover:bg-gray-100">
                                    Voir toutes les notifications
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                            <img class="h-full w-full object-cover" src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" alt="{{ Auth::user()->name }}">
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-50">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
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

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
