@extends('layouts.app')

@section('title', $book->title ?? 'Détails du livre')
@section('header', 'Détails du livre')

@section('content')
<div class="overflow-hidden bg-white shadow sm:rounded-lg">
  <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
      <div>
          <nav class="flex" aria-label="Breadcrumb">
              <ol role="list" class="flex items-center space-x-4">
                  <li>
                      <div class="flex items-center">
                          <a href="{{ route('books.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Livres</a>
                          <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                          </svg>
                      </div>
                  </li>
                  <li>
                      <div class="flex items-center">
                          <span class="text-sm font-medium text-gray-900">{{ $book->title ?? 'Le Seigneur des Anneaux' }}</span>
                      </div>
                  </li>
              </ol>
          </nav>
      </div>
      <div class="flex space-x-3">
          <a href="{{ route('books.edit', $book->id ?? 1) }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
              <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
              </svg>
              Modifier
          </a>
          <form action="{{ route('books.destroy', $book->id ?? 1) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-red-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre?')">
                  <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  Supprimer
              </button>
          </form>
      </div>
  </div>
  
  <div class="border-t border-gray-200">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 py-5 sm:p-6">
          <div class="md:col-span-1">
              <div class="aspect-w-3 aspect-h-4 overflow-hidden rounded-lg bg-gray-100">
                  <img src="{{ $book->cover_image ?? 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $book->title ?? 'Couverture du livre' }}" class="h-full w-full object-cover object-center">
              </div>

              <div class="mt-6">
                  <h4 class="text-sm font-medium text-gray-900">Statut</h4>
                  <div class="mt-2">
                      @if(isset($book->is_available) && $book->is_available)
                      <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                          Disponible
                      </span>
                      @else
                      <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                          Emprunté
                      </span>
                      @endif
                  </div>
              </div>

              <div class="mt-6">
                  <a href="{{ route('emprunts.create', ['book_id' => $book->id ?? 1]) }}" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                      <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                      Emprunter ce livre
                  </a>
              </div>
          </div>

          <div class="md:col-span-2">
              <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                  <div class="sm:col-span-2">
                      <dt class="text-sm font-medium text-gray-500">Titre</dt>
                      <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $book->title ?? 'Le Seigneur des Anneaux' }}</dd>
                  </div>
                  <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500">Auteur</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ $book->author->name ?? 'J.R.R. Tolkien' }}</dd>
                  </div>
                  <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500">Catégorie</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ $book->category->name ?? 'Fantasy' }}</dd>
                  </div>
                  <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ $book->isbn ?? '978-0261103573' }}</dd>
                  </div>
                  <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500">Année de publication</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ $book->publication_year ?? '1954' }}</dd>
                  </div>
                  <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500">Langue</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ $book->language ?? 'Français' }}</dd>
                  </div>
                  <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500">Nombre de pages</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ $book->pages ?? '423' }}</dd>
                  </div>
                  <div class="sm:col-span-2">
                      <dt class="text-sm font-medium text-gray-500">Description</dt>
                      <dd class="mt-1 text-sm text-gray-900">
                          {{ $book->description ?? 'Le Seigneur des anneaux est un roman de fantasy épique écrit par l\'écrivain britannique J. R. R. Tolkien. L\'histoire raconte la quête du jeune hobbit Frodon qui doit détruire l\'Anneau unique pour empêcher Sauron, le Seigneur des ténèbres, de régner sur la Terre du Milieu.' }}
                      </dd>
                  </div>
              </dl>

              <div class="mt-8 border-t border-gray-200 pt-6">
                  <h4 class="text-base font-medium text-gray-900">Historique des emprunts</h4>
                  <div class="mt-4 flow-root">
                      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                              <table class="min-w-full divide-y divide-gray-300">
                                  <thead>
                                      <tr>
                                          <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Membre</th>
                                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date d'emprunt</th>
                                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date de retour</th>
                                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                                      </tr>
                                  </thead>
                                  <tbody class="divide-y divide-gray-200">
                                      @forelse($book->borrowings ?? [] as $borrowing)
                                      <tr>
                                          <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $borrowing->member->name ?? 'Jean Dupont' }}</td>
                                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $borrowing->borrowed_at ?? '2023-05-15' }}</td>
                                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $borrowing->returned_at ?? '2023-06-15' }}</td>
                                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                              @if(isset($borrowing->returned_at) && $borrowing->returned_at)
                                              <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                  Retourné
                                              </span>
                                              @else
                                              <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                                  En cours
                                              </span>
                                              @endif
                                          </td>
                                      </tr>
                                      @empty
                                      <tr>
                                          <td colspan="4" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-500 sm:pl-0 text-center">Aucun historique d'emprunt pour ce livre</td>
                                      </tr>
                                      @endforelse
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

