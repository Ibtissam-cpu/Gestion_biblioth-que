@extends('layouts.app')

@section('title', 'Gestion des recommandations')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion des recommandations</h1>
        <a href="{{ route('recommandations.admin.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajouter une recommandation
        </a>
    </div>
    
    <div class="mb-6">
        <form action="{{ route('recommandations.admin.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par titre ou auteur..." 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-full md:w-48">
                <select name="categorie" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded-lg">
                Filtrer
            </button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Livre</th>
                    <th class="py-2 px-4 border-b text-left">Catégorie</th>
                    <th class="py-2 px-4 border-b text-left">Recommandé par</th>
                    <th class="py-2 px-4 border-b text-left">Date</th>
                    <th class="py-2 px-4 border-b text-left">Commentaire</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recommandations as $recommandation)
                <tr>
                    <td class="py-2 px-4 border-b">
                        <div class="flex items-center">
                            @if($recommandation->livre->image)
                                <img src="{{ asset('storage/' . $recommandation->livre->image) }}" alt="{{ $recommandation->livre->titre }}" class="w-10 h-12 object-cover mr-3">
                            @else
                                <div class="w-10 h-12 bg-gray-200 flex items-center justify-center text-gray-500 mr-3">
                                    No img
                                </div>
                            @endif
                            <a href="{{ route('livres.show', $recommandation->livre->id) }}" class="text-blue-600 hover:underline">
                                {{ $recommandation->livre->titre }}
                            </a>
                        </div>
                    </td>
                    <td class="py-2 px-4 border-b">{{ $recommandation->livre->categorie->nom }}</td>
                    <td class="py-2 px-4 border-b">{{ $recommandation->user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $recommandation->created_at->format('d/m/Y') }}</td>
                    <td class="py-2 px-4 border-b">
                        <span class="line-clamp-1">{{ $recommandation->commentaire }}</span>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <div class="flex space-x-2">
                            <a href="{{ route('recommandations.admin.edit', $recommandation->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('recommandations.admin.destroy', $recommandation->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette recommandation?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 border-b text-center text-gray-500">Aucune recommandation trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $recommandations->links() }}
    </div>
</div>
@endsection