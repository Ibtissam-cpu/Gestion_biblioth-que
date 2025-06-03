@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium mb-8">Recommandations</h3>

    <!-- Recommandations basées sur vos intérêts -->
    <div class="mb-12">
        <h4 class="text-xl font-semibold mb-6">Basé sur vos intérêts</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($recommandationsCategories as $livre)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="relative pb-48">
                        <img src="{{ $livre->image ? asset('storage/' . $livre->image) : asset('images/default-book.png') }}" 
                             alt="{{ $livre->titre }}"
                             class="absolute h-full w-full object-cover">
                    </div>
                    <div class="p-4">
                        <h5 class="text-lg font-semibold mb-2 truncate">{{ $livre->titre }}</h5>
                        <p class="text-gray-600 text-sm mb-2">{{ $livre->auteur->nom }}</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($livre->categories as $categorie)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    {{ $categorie->nom }}
                                </span>
                            @endforeach
                        </div>
                        <a href="{{ route('livres.show', $livre) }}" 
                           class="block text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-150">
                            Voir plus
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-4 bg-white rounded-lg shadow p-6 text-center text-gray-600">
                    Aucune recommandation basée sur vos intérêts pour le moment.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Livres populaires -->
    <div class="mb-12">
        <h4 class="text-xl font-semibold mb-6">Les plus populaires</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($livresPopulaires as $livre)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="relative pb-48">
                        <img src="{{ $livre->image ? asset('storage/' . $livre->image) : asset('images/default-book.png') }}" 
                             alt="{{ $livre->titre }}"
                             class="absolute h-full w-full object-cover">
                    </div>
                    <div class="p-4">
                        <h5 class="text-lg font-semibold mb-2 truncate">{{ $livre->titre }}</h5>
                        <p class="text-gray-600 text-sm mb-2">{{ $livre->auteur->nom }}</p>
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-users mr-2"></i>
                            {{ $livre->emprunts_count }} emprunt(s)
                        </p>
                        <a href="{{ route('livres.show', $livre) }}" 
                           class="block text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-150">
                            Voir plus
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Nouveautés -->
    <div>
        <h4 class="text-xl font-semibold mb-6">Nouveautés</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($nouveautes as $livre)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="relative pb-48">
                        <img src="{{ $livre->image ? asset('storage/' . $livre->image) : asset('images/default-book.png') }}" 
                             alt="{{ $livre->titre }}"
                             class="absolute h-full w-full object-cover">
                    </div>
                    <div class="p-4">
                        <h5 class="text-lg font-semibold mb-2 truncate">{{ $livre->titre }}</h5>
                        <p class="text-gray-600 text-sm mb-2">{{ $livre->auteur->nom }}</p>
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Ajouté {{ $livre->created_at->diffForHumans() }}
                        </p>
                        <a href="{{ route('livres.show', $livre) }}" 
                           class="block text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-150">
                            Voir plus
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 