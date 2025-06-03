@extends('layouts.app')

@section('title', 'Mes Emprunts')

@section('content')
<!-- Barre de recherche -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 mx-auto max-w-4xl">
  <form action="{{ route('emprunts.index') }}" method="GET">
      <div class="flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par titre, auteur..." 
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

<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="section-title">Mes Emprunts</h1>
        <a href="{{ route('emprunts.create') }}" class="btn-primary">Emprunter un livre</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Livre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date d'emprunt</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date de retour prévue</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date de retour effective</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Statut</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($emprunts as $emprunt)
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $emprunt->date_retour_effective ?? 'Non retourné' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @php
                                $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($emprunt->date_retour_prevue), false);
                                $isLate = $daysLeft < 0;
                                $badgeClass = $isLate ? 'bg-red-100 text-red-800' : ($daysLeft <= 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                                $daysText = $isLate ? 'Retard de ' . abs($daysLeft) . ' jour(s)' : 'Retour dans ' . $daysLeft . ' jour(s)';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                {{ $emprunt->statut }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('emprunts.show', $emprunt->id) }}" class="text-blue-500 hover:text-blue-600">Voir</a>
                                @if(!$emprunt->date_retour_effective)
                                <form action="{{ route('emprunts.return', $emprunt->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-blue-500 hover:text-blue-600">Retourner</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center" colspan="6">
                            Aucun emprunt trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $emprunts->links() }}
    </div>
</div>
@endsection






