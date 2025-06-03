@extends('layouts.dashboard')

@section('styles')
<style>
    /* Variables de couleurs améliorées */
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #64748b;
        --success: #059669;
        --info: #0284c7;
        --warning: #d97706;
        --danger: #dc2626;
        --light: #f8fafc;
        --dark: #111827;
        --gray-light: #f3f4f6;
    }
    
    /* Styles de base améliorés */
    body {
        background-color: #f9fafb;
        font-family: 'Inter', sans-serif;
    }
    
    /* Cartes statistiques améliorées */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid rgba(229, 231, 235, 0.5);
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
    
    /* Icônes des statistiques améliorées */
    .stats-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(79, 70, 229, 0.2) 100%);
        color: var(--primary);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover .stats-icon {
        transform: scale(1.1);
    }
    
    /* Navigation latérale améliorée */
    .sidebar-link {
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        margin: 0.25rem 0.75rem;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        color: #4b5563;
    }
    
    .sidebar-link:hover, .sidebar-link.active {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(79, 70, 229, 0.15) 100%);
        color: var(--primary);
    }
    
    .sidebar-link i {
        width: 1.5rem;
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }
    
    /* En-tête de carte amélioré */
    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 1.25rem;
        color: white;
        font-weight: 600;
        border-radius: 1rem 1rem 0 0;
    }
    
    /* Tableaux améliorés */
    .table-responsive {
        border-radius: 0 0 1rem 1rem;
    }
    
    .table-hover tr {
        transition: all 0.2s ease;
    }
    
    .table-hover tr:hover {
        background-color: rgba(79, 70, 229, 0.05);
    }
    
    /* Badges et étiquettes améliorés */
    .notification-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 20px;
        height: 20px;
        background: linear-gradient(135deg, var(--danger) 0%, #ef4444 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        border: 2px solid white;
    }
    
    /* Animations améliorées */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    /* Délais d'animation personnalisés */
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    
    /* Styles de recherche améliorés */
    .search-bar {
        background-color: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.5rem;
        color: white;
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
    }
    
    .search-bar:focus {
        background-color: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
        outline: none;
    }
    
    .search-bar::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    
    /* Styles de tendance améliorés */
    .stats-trend {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-weight: 600;
    }
    
    .stats-trend.up {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.2) 100%);
        color: var(--success);
    }
    
    .stats-trend.down {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.2) 100%);
        color: var(--danger);
    }
    
    /* Styles de menu déroulant améliorés */
    .dropdown-menu {
        display: none;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(229, 231, 235, 0.5);
        overflow: hidden;
    }
    
    .dropdown:hover .dropdown-menu {
        display: block;
        animation: fadeInDown 0.3s ease forwards;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('content')
<div class="flex flex-col min-h-screen bg-gray-50">
    <!-- Header/Navbar -->
    <nav class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-white bg-opacity-10 rounded-lg">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
                <span class="text-2xl font-bold tracking-tight">BiblioGest</span>
            </div>
            <div class="flex items-center space-x-6">
                <!-- Barre de recherche -->
                <div class="relative hidden md:block">
                    <input type="text" 
                           placeholder="Rechercher un livre, un auteur..." 
                           class="search-bar w-72 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                    <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-opacity-60"></i>
                </div>
                
                <!-- Notifications -->
                <div class="relative">
                    <button class="p-2 rounded-full hover:bg-white hover:bg-opacity-10 transition-colors duration-200 focus:outline-none">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="notification-badge">3</span>
                    </button>
                </div>
                
                <!-- Messages -->
                <div class="relative hidden md:block">
                    <button class="p-2 rounded-full hover:bg-white hover:bg-opacity-10 transition-colors duration-200 focus:outline-none">
                        <i class="fas fa-envelope text-lg"></i>
                    </button>
                </div>
                
                <!-- Menu utilisateur -->
                <div class="relative dropdown">
                    <button class="flex items-center space-x-3 p-2 rounded-full hover:bg-white hover:bg-opacity-10 transition-colors duration-200 focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-white text-indigo-600 flex items-center justify-center font-bold text-lg shadow-inner">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-white text-opacity-70">{{ Auth::user()->email }}</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs hidden md:block"></i>
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-50">
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-user mr-3 text-indigo-500 w-5"></i>
                            Mon profil
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-cog mr-3 text-indigo-500 w-5"></i>
                            Paramètres
                        </a>
                        <hr class="my-2 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-3 text-indigo-500 w-5"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-72 bg-white shadow-lg z-10 hidden md:flex md:flex-col">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Menu principal</h2>
                <p class="text-sm text-gray-500 mt-1">Gestion de la bibliothèque</p>
            </div>
            <nav class="flex-1 overflow-y-auto">
                <div class="px-4 py-2">
                    <ul class="space-y-1">
                    <li>
                            <a href="{{ route('dashboard') }}" class="sidebar-link active group">
                                <i class="fas fa-tachometer-alt w-5 text-lg"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                            <a href="{{ route('livres.index') }}" class="sidebar-link group">
                                <i class="fas fa-book w-5 text-lg"></i>
                            <span>Catalogue de livres</span>
                        </a>
                    </li>
                    <li>
                            <a href="{{ route('auteurs.index') }}" class="sidebar-link group">
                                <i class="fas fa-user-edit w-5 text-lg"></i>
                            <span>Gestion des auteurs</span>
                        </a>
                    </li>
                    <li>
                            <a href="{{ route('emprunts.index') }}" class="sidebar-link group">
                                <i class="fas fa-exchange-alt w-5 text-lg"></i>
                            <span>Emprunts & Retours</span>
                        </a>
                    </li>
                    <li>
                            <a href="{{ route('categories.index') }}" class="sidebar-link group">
                                <i class="fas fa-tags w-5 text-lg"></i>
                            <span>Catégories</span>
                        </a>
                    </li>
                    @if(Auth::user()->isAdmin())
                    <li>
                            <a href="{{ route('users.index') }}" class="sidebar-link group">
                                <i class="fas fa-users w-5 text-lg"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    @endif
                    <li>
                            <a href="{{ route('historique') }}" class="sidebar-link group">
                                <i class="fas fa-history w-5 text-lg"></i>
                            <span>Historique</span>
                        </a>
                    </li>
                    <li>
                            <a href="{{ route('stats') }}" class="sidebar-link group">
                                <i class="fas fa-chart-bar w-5 text-lg"></i>
                            <span>Statistiques</span>
                        </a>
                    </li>
                    <li>
                            <a href="{{ route('settings') }}" class="sidebar-link group">
                                <i class="fas fa-cogs w-5 text-lg"></i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                </ul>
                </div>
            </nav>
            
            <!-- Support section -->
            <div class="p-6 border-t bg-gradient-to-br from-indigo-50 to-purple-50">
                <div class="rounded-xl bg-white p-4 shadow-sm border border-indigo-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-500">
                            <i class="fas fa-headset text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">Besoin d'aide ?</h4>
                            <p class="text-xs text-gray-500 mt-1">Notre équipe est là pour vous aider</p>
                        </div>
                    </div>
                    <a href="#" class="mt-4 flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-comments mr-2"></i>
                        Contacter le support
                    </a>
                </div>
            </div>
        </aside>

        <!-- Contenu principal -->
        <main class="flex-1 p-8">
            <!-- En-tête avec fil d'Ariane -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <div class="text-sm breadcrumbs text-gray-500 mb-2">
                        <ul class="flex items-center space-x-2">
                            <li class="flex items-center">
                                <i class="fas fa-home text-gray-400 mr-2"></i>
                                <a href="#" class="hover:text-primary">Accueil</a>
                            </li>
                            <li class="flex items-center before:content-['/'] before:mx-2 before:text-gray-300">
                                <span class="text-gray-600">Tableau de bord</span>
                            </li>
                        </ul>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tableau de bord</h1>
                    <p class="text-gray-600">Bienvenue dans votre espace de gestion de bibliothèque</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-4">
                    <button class="flex items-center space-x-2 bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-calendar-alt text-primary"></i>
                        <span>{{ now()->format('d M Y') }}</span>
                    </button>
                    <button class="flex items-center space-x-2 bg-primary hover:bg-primary-dark rounded-xl px-4 py-2 text-sm font-medium text-white transition-colors duration-200">
                        <i class="fas fa-plus"></i>
                        <span>Ajouter un livre</span>
                    </button>
                </div>
            </div>

            <!-- Cartes de statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Carte "Livres" -->
                <div class="bg-white rounded-xl shadow-sm stat-card animate-fadeInUp delay-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Livres disponibles</h3>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['livres'] }}</p>
                                <div class="flex items-center">
                                    <span class="stats-trend up flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        2.5%
                                    </span>
                                    <span class="text-gray-500 text-xs ml-2">depuis le mois dernier</span>
                                </div>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-book text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte "Auteurs" -->
                <div class="bg-white rounded-xl shadow-sm stat-card animate-fadeInUp delay-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Auteurs</h3>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['auteurs'] }}</p>
                                <div class="flex items-center">
                                    <span class="stats-trend up flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        1.8%
                                    </span>
                                    <span class="text-gray-500 text-xs ml-2">depuis le mois dernier</span>
                                </div>
                            </div>
                            <div class="stats-icon" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.2) 100%); color: #ef4444;">
                                <i class="fas fa-user-edit text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte "Catégories" -->
                <div class="bg-white rounded-xl shadow-sm stat-card animate-fadeInUp delay-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Catégories</h3>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['categories'] }}</p>
                                <div class="flex items-center">
                                    <span class="stats-trend up flex items-center" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.2) 100%);">
                                        <i class="fas fa-equals mr-1"></i>
                                        0%
                                    </span>
                                    <span class="text-gray-500 text-xs ml-2">stable</span>
                                </div>
                            </div>
                            <div class="stats-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.2) 100%); color: #10b981;">
                                <i class="fas fa-tags text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte "Emprunts Actifs" -->
                <div class="bg-white rounded-xl shadow-sm stat-card animate-fadeInUp delay-400">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Emprunts actifs</h3>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['empruntsActifs'] }}</p>
                                <div class="flex items-center">
                                    <span class="stats-trend down flex items-center">
                                        <i class="fas fa-arrow-down mr-1"></i>
                                        3.2%
                                    </span>
                                    <span class="text-gray-500 text-xs ml-2">depuis le mois dernier</span>
                                </div>
                            </div>
                            <div class="stats-icon" style="background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(249, 115, 22, 0.2) 100%); color: #f97316;">
                                <i class="fas fa-exchange-alt text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tableaux et graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Emprunts récents -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="card-header flex items-center justify-between">
                        <h3 class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Emprunts récents
                        </h3>
                        <div class="flex items-center space-x-2">
                            <button class="text-white text-opacity-80 hover:text-opacity-100 transition-opacity">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button class="text-white text-opacity-80 hover:text-opacity-100 transition-opacity">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    
                    @if($stats['empruntsActifs'] === 0)
                        <div class="p-8 text-center">
                            <div class="mx-auto w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-book-open text-gray-400 text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Aucun emprunt récent</h4>
                            <p class="text-gray-500">Les emprunts récents s'afficheront ici</p>
                            <a href="{{ route('emprunts.create') }}" class="mt-4 inline-flex items-center text-primary hover:text-primary-dark transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Créer un nouvel emprunt
                            </a>
                        </div>
                    @else
                        @php
                            $empruntsActifs = Auth::user()->emprunts()->with('livre.auteur')->whereNull('date_retour')->paginate(5);
                        @endphp
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'emprunt</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Retour prévu</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($empruntsActifs as $emprunt)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary font-bold">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $emprunt->livre->titre }}</div>
                                            <div class="text-sm text-gray-500">{{ $emprunt->livre->auteur->nom }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $emprunt->date_emprunt->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $emprunt->date_emprunt->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $emprunt->date_retour_prevue->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $isLate = now()->gt($emprunt->date_retour_prevue);
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $isLate ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $isLate ? 'En retard' : 'À jour' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    Affichage de {{ $empruntsActifs->firstItem() }} à {{ $empruntsActifs->lastItem() }} sur {{ $empruntsActifs->total() }} emprunts
                                </div>
                                <a href="{{ route('emprunts.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-primary hover:text-primary-dark transition-colors">
                                    Voir tous les emprunts
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Notifications -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="card-header flex items-center justify-between">
                        <h3 class="flex items-center">
                            <i class="fas fa-bell mr-2"></i>
                            Notifications récentes
                        </h3>
                        <div class="flex items-center space-x-2">
                            <button class="text-white text-opacity-80 hover:text-opacity-100 transition-opacity">
                                <i class="fas fa-check-double"></i>
                            </button>
                            <button class="text-white text-opacity-80 hover:text-opacity-100 transition-opacity">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        <!-- Notification 1 -->
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-900">Retour en retard</p>
                                    <p class="text-sm text-gray-500 mt-1">Le livre "Les Misérables" est en retard depuis 3 jours.</p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-xs text-gray-400">Il y a 2 heures</span>
                                        <button class="text-xs text-primary hover:text-primary-dark transition-colors">
                                            Marquer comme lu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notification 2 -->
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-900">Nouveau livre ajouté</p>
                                    <p class="text-sm text-gray-500 mt-1">"L'Étranger" d'Albert Camus a été ajouté au catalogue.</p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-xs text-gray-400">Hier</span>
                                        <button class="text-xs text-primary hover:text-primary-dark transition-colors">
                                            Voir le livre
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notification 3 -->
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-900">Nouvel utilisateur</p>
                                    <p class="text-sm text-gray-500 mt-1">Marie Dupont s'est inscrite à la bibliothèque.</p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-xs text-gray-400">Il y a 2 jours</span>
                                        <button class="text-xs text-primary hover:text-primary-dark transition-colors">
                                            Voir le profil
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-gray-50 border-t border-gray-200">
                        <a href="#" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-primary hover:text-primary-dark transition-colors">
                            Voir toutes les notifications
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Deuxième rangée de widgets -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Livres populaires -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="card-header flex items-center justify-between">
                        <h3 class="flex items-center">
                            <i class="fas fa-fire mr-2"></i>
                            Livres populaires
                        </h3>
                        <div class="flex items-center space-x-2">
                            <button class="text-white text-opacity-80 hover:text-opacity-100 transition-opacity">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button class="text-white text-opacity-80 hover:text-opacity-100 transition-opacity">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Contenu des livres populaires -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Livre 1 -->
                            <div class="group flex items-center p-4 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-indigo-100 transition-all duration-200">
                                <div class="flex-shrink-0 w-16 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-book text-indigo-500 text-xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-sm font-medium text-gray-900">L'Étranger</h4>
                                    <p class="text-xs text-gray-500">Albert Camus</p>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-amber-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">4.5/5</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-users text-xs mr-1"></i>
                                            32 emprunts
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Livre 2 -->
                            <div class="group flex items-center p-4 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-indigo-100 transition-all duration-200">
                                <div class="flex-shrink-0 w-16 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-book text-indigo-500 text-xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-sm font-medium text-gray-900">Le Petit Prince</h4>
                                    <p class="text-xs text-gray-500">Antoine de Saint-Exupéry</p>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-amber-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">5/5</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-users text-xs mr-1"></i>
                                            28 emprunts
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Livre 3 -->
                            <div class="group flex items-center p-4 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-indigo-100 transition-all duration-200">
                                <div class="flex-shrink-0 w-16 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-book text-indigo-500 text-xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-sm font-medium text-gray-900">1984</h4>
                                    <p class="text-xs text-gray-500">George Orwell</p>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-amber-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">4/5</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-users text-xs mr-1"></i>
                                            24 emprunts
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Livre 4 -->
                            <div class="group flex items-center p-4 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-indigo-100 transition-all duration-200">
                                <div class="flex-shrink-0 w-16 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-book text-indigo-500 text-xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-sm font-medium text-gray-900">Algorithmes en Java</h4>
                                    <p class="text-xs text-gray-500">Robert Sedgewick</p>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-amber-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">3.5/5</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-users text-xs mr-1"></i>
                                            19 emprunts
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                Les livres les plus empruntés ce mois-ci
                            </div>
                            <a href="{{ route('livres.populaires') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">
                                Voir tous les livres populaires
                                <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection