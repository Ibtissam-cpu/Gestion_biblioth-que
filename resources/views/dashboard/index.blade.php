@extends('layouts.app')

@section('title', 'Tableau de bord')

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

<!-- Statistiques -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
  <div class="bg-white rounded-lg shadow-sm p-5">
      <div class="flex items-center">
          <div class="flex-shrink-0 rounded-full bg-blue-100 p-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
          </div>
          <div class="ml-5 w-0 flex-1">
              <dl>
                  <dt class="truncate text-sm font-medium text-gray-600">Total des livres</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ $totalLivres ?? 0 }}</dd>
              </dl>
          </div>
      </div>
      <div class="mt-4 text-sm">
          <a href="{{ route('livres.index') }}" class="text-blue-500 hover:text-blue-600 flex items-center">
              <span>Voir tous les livres</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
          </a>
      </div>
  </div>

  <div class="bg-white rounded-lg shadow-sm p-5">
      <div class="flex items-center">
          <div class="flex-shrink-0 rounded-full bg-blue-100 p-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
          </div>
          <div class="ml-5 w-0 flex-1">
              <dl>
                  <dt class="truncate text-sm font-medium text-gray-600">Auteurs</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ $totalAuteurs ?? 0 }}</dd>
              </dl>
          </div>
      </div>
      <div class="mt-4 text-sm">
          <a href="{{ route('auteurs.index') }}" class="text-blue-500 hover:text-blue-600 flex items-center">
              <span>Voir tous les auteurs</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
          </a>
      </div>
  </div>

  <div class="bg-white rounded-lg shadow-sm p-5">
      <div class="flex items-center">
          <div class="flex-shrink-0 rounded-full bg-blue-100 p-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
          </div>
          <div class="ml-5 w-0 flex-1">
              <dl>
                  <dt class="truncate text-sm font-medium text-gray-600">Catégories</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ $totalCategories ?? 0 }}</dd>
              </dl>
          </div>
      </div>
      <div class="mt-4 text-sm">
          <a href="{{ route('categories.index') }}" class="text-blue-500 hover:text-blue-600 flex items-center">
              <span>Voir toutes les catégories</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
          </a>
      </div>
  </div>

  <div class="bg-white rounded-lg shadow-sm p-5">
      <div class="flex items-center">
          <div class="flex-shrink-0 rounded-full bg-blue-100 p-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
              </svg>
          </div>
          <div class="ml-5 w-0 flex-1">
              <dl>
                  <dt class="truncate text-sm font-medium text-gray-600">Mes emprunts actifs</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ $mesEmpruntsActifs ?? 0 }}</dd>
              </dl>
          </div>
      </div>
      <div class="mt-4 text-sm">
          <a href="{{ route('emprunts.index') }}" class="text-blue-500 hover:text-blue-600 flex items-center">
              <span>Voir mes emprunts</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
          </a>
      </div>
  </div>
</div>

<!-- Mes emprunts actifs -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
  <div class="flex justify-between items-center mb-4">
      <h2 class="section-title">Mes emprunts actifs</h2>
      <a href="{{ route('emprunts.create') }}" class="btn-primary flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Emprunter
      </a>
  </div>
  
  @if(isset($empruntsActifs) && count($empruntsActifs) > 0)
  <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
              <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Livre</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date d'emprunt</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date de retour</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Statut</th>
                  <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
              </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
              @foreach($empruntsActifs as $emprunt)
              <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                          <div class="flex-shrink-0 h-10 w-10">
                              <img class="h-10 w-10 rounded-md object-cover" src="{{ $emprunt->livre->image_couverture ?? 'https://via.placeholder.com/40' }}" alt="">
                          </div>
                          <div class="ml-4">
                              <div class="text-sm font-medium text-gray-900">{{ $emprunt->livre->titre }}</div>
                              <div class="text-sm text-gray-600">{{ $emprunt->livre->auteur->nom }}</div>
                          </div>
                      </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      {{ $emprunt->date_emprunt }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      {{ $emprunt->date_retour_prevue }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                      @php
                          $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($emprunt->date_retour_prevue), false);
                          $isLate = $daysLeft < 0;
                          $badgeClass = $isLate ? 'bg-red-100 text-red-800' : ($daysLeft <= 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                          $daysText = $isLate ? 'Retard de ' . abs($daysLeft) . ' jour(s)' : 'Retour dans ' . $daysLeft . ' jour(s)';
                      @endphp
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                          {{ $daysText }}
                      </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a href="{{ route('emprunts.show', $emprunt->id) }}" class="text-blue-500 hover:text-blue-600 mr-3">Détails</a>
                      <form action="{{ route('emprunts.return', $emprunt->id) }}" method="POST" class="inline">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="text-blue-500 hover:text-blue-600">Retourner</button>
                      </form>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
  @else
  <div class="text-center py-8">
      <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun emprunt actif</h3>
      <p class="mt-1 text-sm text-gray-600">Commencez par emprunter un livre dans notre catalogue.</p>
      <div class="mt-6">
          <a href="{{ route('livres.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none">
              Parcourir le catalogue
          </a>
      </div>
  </div>
  @endif
</div>

<!-- Recommandé pour vous -->
<div class="bg-white rounded-lg shadow-sm p-6">
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



