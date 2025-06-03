@extends('layouts.app')

@section('title', 'Recommandations')

@section('content')
<!-- Barre de recherche -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 mx-auto max-w-4xl">
  <form action="{{ route('recommandations.index') }}" method="GET">
      <div class="flex">
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher par titre, auteur, ISBN..." 
                 class="flex-grow border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          <button type="submit" class="btn-search">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Rechercher
          </button>
      </div>
      
      <div class="flex flex-wrap gap-6 mt-4">
          <div>
              <label for="categorie" class="filter-label block">Catégorie:</label>
              <select id="categorie" name="categorie" class="filter-select">
                  <option value="">Toutes les catégories</option>
                  @foreach($categories ?? [] as $categorie)
                  <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                      {{ $categorie->nom }}
                  </option>
                  @endforeach
              </select>
          </div>
          
          <div>
              <label for="disponibilite" class="filter-label block">Disponibilité:</label>
              <select id="disponibilite" name="disponibilite" class="filter-select">
                  <option value="">Tous</option>
                  <option value="disponible" {{ request('disponibilite') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                  <option value="indisponible" {{ request('disponibilite') == 'indisponible' ? 'selected' : '' }}>Indisponible</option>
              </select>
          </div>
          
          <div>
              <label for="annee" class="filter-label block">Année:</label>
              <select id="annee" name="annee" class="filter-select">
                  <option value="">Toutes les années</option>
                  @for($i = date('Y'); $i >= 1900; $i--)
                  <option value="{{ $i }}" {{ request('annee') == $i ? 'selected' : '' }}>{{ $i }}</option>
                  @endfor
              </select>
          </div>
      </div>
  </form>
</div>

<!-- Recommandations -->
<div class="bg-white rounded-lg shadow-sm p-6">
  <h1 class="section-title mb-6">Recommandations personnalisées</h1>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($recommandations ?? [] as $livre)
      <div class="card-content rounded-lg overflow-hidden shadow-sm">
          <img src="{{ $livre->image_couverture ?? 'https://via.placeholder.com/180x250' }}" 
               alt="{{ $livre->titre }}" 
               class="w-full h-48 object-cover">
          <div class="p-4">
              <h3 class="font-medium mb-1">
                  <a href="{{ route('livres.show', $livre->id) }}" class="hover:text-blue-500">
                      {{ $livre->titre }}
                  </a>
              </h3>
              <p class="text-sm text-gray-600 mb-3">Par {{ $livre->auteur->nom }}</p>
              
              <div class="flex justify-between items-center">
                  <span class="text-sm italic text-gray-600">{{ $livre->categorie->nom }}</span>
                  
                  @if($livre->disponible)
                  <span class="status-available text-sm">
                      Disponible
                  </span>
                  @else
                  <span class="status-unavailable text-sm">
                      Indisponible
                  </span>
                  @endif
              </div>
              
              <div class="mt-4 flex justify-between items-center">
                  <a href="{{ route('livres.show', $livre->id) }}" class="text-blue-500 hover:text-blue-600 text-sm">
                      Détails
                  </a>
                  
                  @if($livre->disponible)
                  <a href="{{ route('emprunts.create', ['livre_id' => $livre->id]) }}" 
                     class="btn-primary">
                      Emprunter
                  </a>
                  @else
                  <a href="#" class="btn-reserve">
                      Réserver
                  </a>
                  @endif
              </div>
          </div>
      </div>
      @empty
      <div class="col-span-full text-center py-8">
          <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Pas encore de recommandations</h3>
          <p class="mt-1 text-sm text-gray-600">Empruntez des livres pour recevoir des recommandations personnalisées.</p>
      </div>
      @endforelse
  </div>
</div>
@endsection
