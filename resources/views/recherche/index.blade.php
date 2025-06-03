@extends('layouts.app')

@section('title', 'Recherche')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Recherche</h1>
    
    <form action="{{ route('recherche.index') }}" method="GET" class="mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher des livres, auteurs, catégories..." 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-full md:w-48">
                <select name="type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Tout</option>
                    <option value="livres" {{ request('type') == 'livres' ? 'selected' : '' }}>Livres</option>
                    <option value="auteurs" {{ request('type') == 'auteurs' ? 'selected' : '' }}>Auteurs</option>
                    <option value="categories" {{ request('type') == 'categories' ? 'selected' : '' }}>Catégories</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                Rechercher
            </button>
        </div>
    </form>
    
    @if(request('q'))
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Résultats pour "{{ request('q') }}"</h2>
            <p class="text-gray-600">{{ $totalResults ?? 0 }} résultat(s) trouvé(s)</p>
        </div>
        
        @if(isset($livres) && count($livres) > 0 && (request('type') == 'all' || request('type') == 'livres'))
            <div class="mb-8">
                <h3 class="text-lg font-medium mb-4">Livres ({{ count($livres) }})</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($livres as $livre)
                    <a href="{{ route('livres.show', $livre->id) }}" class="block bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="h-40 bg-gray-200 overflow-hidden">
                            @if($livre->image)
                                <img src="{{ asset('storage/' . $livre->image) }}" alt="{{ $livre->titre }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                    Pas d'image
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h4 class="font-medium text-sm truncate">{{ $livre->titre }}</h4>
                            <p class="text-gray-600 text-xs">{{ $livre->auteur->nom }}</p>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xs text-gray-500">{{ $livre->annee_publication }}</span>
                                @if($livre->disponible)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Disponible</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Emprunté</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @if(count($livres) > 8)
                    <div class="mt-4 text-center">
                        <a href="{{ route('recherche.index', ['q' => request('q'), 'type' => 'livres']) }}" class="text-blue-600 hover:underline">
                            Voir tous les livres
                        </a>
                    </div>
                @endif
            </div>
        @endif
        
        @if(isset($auteurs) && count($auteurs) > 0 && (request('type') == 'all' || request('type') == 'auteurs'))
            <div class="mb-8">
                <h3 class="text-lg font-medium mb-4">Auteurs ({{ count($auteurs) }})</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($auteurs as $auteur)
                    <a href="{{ route('auteurs.show', $auteur->id) }}" class="block bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow p-4">
                        <div class="flex items-center">
                            @if($auteur->photo)
                                <img src="{{ asset('storage/' . $auteur->photo) }}" alt="{{ $auteur->nom }}" class="w-12 h-12 rounded-full object-cover mr-3">
                            @else
                                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-medium">{{ $auteur->nom }}</h4>
                                <p class="text-gray-600 text-xs">{{ $auteur->nationalite ?? 'Non spécifiée' }}</p>
                                <p class="text-gray-500 text-xs">{{ $auteur->livres_count ?? 0 }} livre(s)</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @if(count($auteurs) > 8)
                    <div class="mt-4 text-center">
                        <a href="{{ route('recherche.index', ['q' => request('q'), 'type' => 'auteurs']) }}" class="text-blue-600 hover:underline">
                            Voir tous les auteurs
                        </a>
                    </div>
                @endif
            </div>
        @endif
        
        @if(isset($categories) && count($categories) > 0 && (request('type') == 'all' || request('type') == 'categories'))
            <div class="mb-8">
                <h3 class="text-lg font-medium mb-4">Catégories ({{ count($categories) }})</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($categories as $categorie)
                    <a href="{{ route('categories.show', $categorie->id) }}" class="block bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow p-4">
                        <h4 class="font-medium">{{ $categorie->nom }}</h4>
                        <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ Str::limit($categorie->description, 100) }}</p>
                        <p class="text-gray-500 text-xs mt-2">{{ $categorie->livres_count ?? 0 }} livre(s)</p>
                    </a>
                    @endforeach
                </div>
                @if(count($categories) > 8)
                    <div class="mt-4 text-center">
                        <a href="{{ route('recherche.index', ['q' => request('q'), 'type' => 'categories']) }}" class="text-blue-600 hover:underline">
                            Voir toutes les catégories
                        </a>
                    </div>
                @endif
            </div>
        @endif
        
        @if((!isset($livres) || count($livres) == 0) && (!isset($auteurs) || count($auteurs) == 0) && (!isset($categories) || count($categories) == 0))
            <div class="text-center py-8 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Aucun résultat trouvé pour "{{ request('q') }}"</p>
                <p class="mt-2 text-sm">Essayez avec d'autres termes ou vérifiez l'orthographe</p>
            </div>
        @endif
    @else
        <div class="text-center py-8 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <p>Entrez un terme de recherche pour trouver des livres, auteurs ou catégories</p>
        </div>
    @endif
</div>
@endsection