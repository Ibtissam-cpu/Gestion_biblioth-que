@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête avec bienvenue -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Bienvenue, {{ Auth::user()->name }} !</h1>
        <p class="text-blue-100">Votre espace personnel de lecture</p>
    </div>

    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Emprunts en cours -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 bg-opacity-75">
                    <i class="fas fa-book text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Emprunts en cours</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $empruntsEnCours }}</p>
                </div>
            </div>
        </div>

        <!-- Total des emprunts -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 bg-opacity-75">
                    <i class="fas fa-history text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Total des emprunts</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $totalEmprunts }}</p>
                </div>
            </div>
        </div>

        <!-- Recommandations -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 bg-opacity-75">
                    <i class="fas fa-star text-purple-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Recommandations</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $recommandationsCount }}</p>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 bg-opacity-75">
                    <i class="fas fa-bell text-yellow-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Notifications</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $notificationsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Emprunts en cours -->
    <div class="bg-white rounded-lg shadow-lg mb-8">
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-xl font-semibold text-gray-800">Mes Emprunts en Cours</h2>
        </div>
        <div class="p-6">
            @if(count($emprunts) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($emprunts as $emprunt)
                        <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="relative pb-48">
                                <img src="{{ $emprunt->livre->image ? asset('storage/' . $emprunt->livre->image) : asset('images/default-book.png') }}" 
                                     class="absolute h-full w-full object-cover" 
                                     alt="{{ $emprunt->livre->titre }}">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $emprunt->livre->titre }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $emprunt->livre->auteur->nom }}</p>
                                <div class="flex justify-between items-center text-sm text-gray-500">
                                    <span><i class="fas fa-calendar-alt mr-2"></i>Retour le: {{ $emprunt->date_retour_prevue->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-book-open text-4xl mb-4"></i>
                    <p>Vous n'avez aucun emprunt en cours.</p>
                    <a href="{{ route('recherche.index') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                        Découvrir des livres
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Section Recommandations -->
    <div class="bg-white rounded-lg shadow-lg mb-8">
        <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Recommandations pour Vous</h2>
            <a href="{{ route('membre.recommandations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="p-6">
            @if(count($recommandations) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($recommandations as $recommandation)
                        <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="relative pb-48">
                                <img src="{{ $recommandation->livre->image ? asset('storage/' . $recommandation->livre->image) : asset('images/default-book.png') }}" 
                                     class="absolute h-full w-full object-cover" 
                                     alt="{{ $recommandation->livre->titre }}">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2 truncate">{{ $recommandation->livre->titre }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $recommandation->livre->auteur->nom }}</p>
                                <a href="{{ route('livres.show', $recommandation->livre) }}" 
                                   class="inline-block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                    Voir plus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-star text-4xl mb-4"></i>
                    <p>Aucune recommandation pour le moment.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Section Historique -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Historique des Emprunts</h2>
            <a href="{{ route('historique.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="p-6">
            @if(count($historique) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Emprunté le</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Retourné le</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($historique as $emprunt)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <img class="h-10 w-10 rounded object-cover" 
                                                     src="{{ $emprunt->livre->image ? asset('storage/' . $emprunt->livre->image) : asset('images/default-book.png') }}" 
                                                     alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $emprunt->livre->titre }}</div>
                                                <div class="text-sm text-gray-500">{{ $emprunt->livre->auteur->nom }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $emprunt->date_emprunt->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $emprunt->date_retour ? $emprunt->date_retour->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $emprunt->date_retour 
                                                ? 'bg-green-100 text-green-800' 
                                                : ($emprunt->est_en_retard 
                                                    ? 'bg-red-100 text-red-800' 
                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $emprunt->date_retour 
                                                ? 'Retourné' 
                                                : ($emprunt->est_en_retard 
                                                    ? 'En retard' 
                                                    : 'En cours') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-history text-4xl mb-4"></i>
                    <p>Aucun historique d'emprunt.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
