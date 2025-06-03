@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<!-- Barre de recherche -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 mx-auto max-w-4xl">
  <form action="{{ route('recherche.index') }}" method="GET">
      <div class="flex">
          <input type="text" name="q" placeholder="Rechercher par titre, auteur, ISBN..." 
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
                  <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                  @endforeach
              </select>
          </div>
          
          <div>
              <label for="disponibilite" class="filter-label block">Disponibilité:</label>
              <select id="disponibilite" name="disponibilite" class="filter-select">
                  <option value="">Tous</option>
                  <option value="disponible">Disponible</option>
                  <option value="indisponible">Indisponible</option>
              </select>
          </div>
          
          <div>
              <label for="annee" class="filter-label block">Année:</label>
              <select id="annee" name="annee" class="filter-select">
                  <option value="">Toutes les années</option>
                  @for($i = date('Y'); $i >= 1900; $i--)
                  <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
              </select>
          </div>
      </div>
  </form>
</div>

<!-- Recommandé pour vous -->
<div class="mb-6">
  <div class="flex justify-between items-center mb-4">
      <h2 class="section-title">Recommandé pour vous</h2>
      <a href="{{ route('recommandations.index') }}" class="see-all-link">Voir tout</a>
  </div>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($livresRecommandes ?? [] as $livre)
      <div class="card-content rounded-lg overflow-hidden shadow-sm">
          <img src="{{ $livre->image_couverture ?? 'https://via.placeholder.com/180x250' }}" 
               alt="{{ $livre->titre }}" 
               class="w-full h-48 object-cover">
          <div class="p-4">
              <h3 class="font-medium mb-1">{{ $livre->titre }}</h3>
              <p class="text-sm text-gray-600 mb-3">Par {{ $livre->auteur->nom }}</p>
              
              @if($livre->disponible)
              <div class="flex justify-between items-center">
                  <span class="status-available text-sm">Disponible</span>
                  <a href="{{ route('emprunts.create', ['livre_id' => $livre->id]) }}" 
                     class="btn-primary">
                      Emprunter
                  </a>
              </div>
              @else
              <div class="flex justify-between items-center">
                  <span class="status-unavailable text-sm">Indisponible</span>
                  <a href="#" class="btn-reserve">
                      Réserver
                  </a>
              </div>
              @endif
          </div>
      </div>
      @empty
      <div class="col-span-full bg-white rounded-lg shadow-sm p-6 text-center">
          <p class="text-gray-600">Aucune recommandation disponible pour le moment.</p>
      </div>
      @endforelse
  </div>
</div>

<!-- Nouveaux arrivages -->
<div class="mb-6">
  <div class="flex justify-between items-center mb-4">
      <h2 class="section-title">Nouveaux arrivages</h2>
      <a href="{{ route('livres.index', ['sort' => 'newest']) }}" class="see-all-link">Voir tout</a>
  </div>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($nouveauxLivres ?? [] as $livre)
      <div class="card-content rounded-lg overflow-hidden shadow-sm">
          <img src="{{ $livre->image_couverture ?? 'https://via.placeholder.com/180x250' }}" 
               alt="{{ $livre->titre }}" 
               class="w-full h-48 object-cover">
          <div class="p-4">
              <h3 class="font-medium mb-1">{{ $livre->titre }}</h3>
              <p class="text-sm text-gray-600 mb-3">Par {{ $livre->auteur->nom }}</p>
              
              @if($livre->disponible)
              <div class="flex justify-between items-center">
                  <span class="status-available text-sm">Disponible</span>
                  <a href="{{ route('emprunts.create', ['livre_id' => $livre->id]) }}" 
                     class="btn-primary">
                      Emprunter
                  </a>
              </div>
              @else
              <div class="flex justify-between items-center">
                  <span class="status-unavailable text-sm">Indisponible</span>
                  <a href="#" class="btn-reserve">
                      Réserver
                  </a>
              </div>
              @endif
          </div>
      </div>
      @empty
      <div class="col-span-full bg-white rounded-lg shadow-sm p-6 text-center">
          <p class="text-gray-600">Aucun nouveau livre disponible pour le moment.</p>
      </div>
      @endforelse
  </div>
</div>

<!-- Nos services -->
<div class="mb-6">
  <h2 class="section-title mb-4">Nos services</h2>
  
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="service-card">
          <div class="flex justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 service-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
          </div>
          <h3 class="text-lg font-medium mb-2">Emprunts & Retours</h3>
          <p class="text-sm text-gray-600">
              Gérez facilement vos emprunts et retours en ligne. Suivez les dates d'échéance et renouvelez vos prêts en quelques clics.
          </p>
      </div>
      
      <div class="service-card">
          <div class="flex justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 service-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
          </div>
          <h3 class="text-lg font-medium mb-2">Historique</h3>
          <p class="text-sm text-gray-600">
              Accédez à l'historique complet de vos activités, consultez vos lectures passées et téléchargez vos reçus.
          </p>
      </div>
      
      <div class="service-card">
          <div class="flex justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 service-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
          </div>
          <h3 class="text-lg font-medium mb-2">Recommandations</h3>
          <p class="text-sm text-gray-600">
              Découvrez des ouvrages adaptés à vos centres d'intérêt grâce à notre système de recommandation personnalisé.
          </p>
      </div>
      
      <div class="service-card">
          <div class="flex justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 service-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
          </div>
          <h3 class="text-lg font-medium mb-2">Notifications</h3>
          <p class="text-sm text-gray-600">
              Restez informé grâce aux notifications automatisées concernant vos échéances, réservations et nouveautés.
          </p>
      </div>
  </div>
</div>
@endsection
