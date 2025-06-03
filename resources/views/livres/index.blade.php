@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')
<!-- Barre de recherche -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 mx-auto max-w-4xl">
  <form action="{{ route('livres.index') }}" method="GET">
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

<!-- Liste des livres -->
<div class="bg-white rounded-lg shadow-sm p-6">
  <div class="flex justify-between items-center mb-6">
      <h1 class="section-title">Catalogue des livres</h1>
      <div class="flex items-center space-x-2">
          <span class="text-sm text-gray-600">Trier par:</span>
          <select id="sort" name="sort" class="filter-select">
              <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Titre (A-Z)</option>
              <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Titre (Z-A)</option>
              <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Auteur</option>
              <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récent</option>
              <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus ancien</option>
          </select>
      </div>
  </div>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($livres ?? [] as $livre)
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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun livre trouvé</h3>
          <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
      </div>
      @endforelse
  </div>
  
  <div class="mt-6">
      {{ $livres->links() ?? '' }}
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const sortSelect = document.getElementById('sort');
      sortSelect.addEventListener('change', function() {
          const currentUrl = new URL(window.location.href);
          currentUrl.searchParams.set('sort', this.value);
          window.location.href = currentUrl.toString();
      });
  });
</script>
@endpush







