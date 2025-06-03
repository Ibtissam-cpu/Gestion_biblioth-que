@extends('layouts.app')

@section('title', 'Auteurs')

@section('content')
<!-- Barre de recherche -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 mx-auto max-w-4xl">
  <form action="{{ route('auteurs.index') }}" method="GET">
      <div class="flex">
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un auteur..." 
                 class="flex-grow border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          <button type="submit" class="btn-search">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Rechercher
          </button>
      </div>
  </form>
</div>

<!-- Liste des auteurs -->
<div class="bg-white rounded-lg shadow-sm p-6">
  <h1 class="section-title mb-6">Liste des auteurs</h1>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($auteurs ?? [] as $auteur)
      <div class="card-content rounded-lg overflow-hidden shadow-sm">
          <div class="p-4">
              <h3 class="font-medium mb-2">
                  <a href="{{ route('auteurs.show', $auteur->id) }}" class="hover:text-blue-500">
                      {{ $auteur->nom }}
                  </a>
              </h3>
              <p class="text-sm text-gray-600 mb-3">{{ $auteur->livres_count ?? 0 }} livre(s)</p>
              
              <div class="mt-4">
                  <a href="{{ route('auteurs.show', $auteur->id) }}" class="text-blue-500 hover:text-blue-600 text-sm">
                      Voir les livres
                  </a>
              </div>
          </div>
      </div>
      @empty
      <div class="col-span-full text-center py-8">
          <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun auteur trouvé</h3>
          <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
      </div>
      @endforelse
  </div>
  
  <div class="mt-6">
      {{ $auteurs->links() ?? '' }}
  </div>
</div>
@endsection
