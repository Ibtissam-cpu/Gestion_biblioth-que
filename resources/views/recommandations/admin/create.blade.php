@extends('layouts.app')

@section('title', 'Ajouter une recommandation')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('recommandations.admin.index') }}" class="text-blue-600 hover:text-blue-800 mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold">Ajouter une recommandation</h1>
    </div>
    
    <form action="{{ route('recommandations.admin.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="livre_id" class="block text-gray-700 font-medium mb-2">Livre</label>
            <select name="livre_id" id="livre_id" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('livre_id') border-red-500 @enderror">
                <option value="">Sélectionner un livre</option>
                @foreach($livres as $livre)
                    <option value="{{ $livre->id }}" {{ old('livre_id') == $livre->id ? 'selected' : '' }}>
                        {{ $livre->titre }} ({{ $livre->auteur->nom }})
                    </option>
                @endforeach
            </select>
            @error('livre_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="commentaire" class="block text-gray-700 font-medium mb-2">Commentaire</label>
            <textarea name="commentaire" id="commentaire" rows="4" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('commentaire') border-red-500 @enderror">{{ old('commentaire') }}</textarea>
            @error('commentaire')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="type" class="block text-gray-700 font-medium mb-2">Type de recommandation</label>
            <select name="type" id="type" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>Générale (pour tous)</option>
                <option value="categorie" {{ old('type') == 'categorie' ? 'selected' : '' }}>Par catégorie</option>
                <option value="age" {{ old('type') == 'age' ? 'selected' : '' }}>Par tranche d'âge</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div id="categorieSection" class="mb-4 hidden">
            <label for="categorie_id" class="block text-gray-700 font-medium mb-2">Catégorie cible</label>
            <select name="categorie_id" id="categorie_id"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('categorie_id') border-red-500 @enderror">
                <option value="">Sélectionner une catégorie</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
            @error('categorie_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div id="ageSection" class="mb-4 hidden">
            <label for="age_min" class="block text-gray-700 font-medium mb-2">Tranche d'âge</label>
            <div class="flex items-center gap-2">
                <input type="number" name="age_min" id="age_min" placeholder="Âge minimum" value="{{ old('age_min') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('age_min') border-red-500 @enderror">
                <span>à</span>
                <input type="number" name="age_max" id="age_max" placeholder="Âge maximum" value="{{ old('age_max') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('age_max') border-red-500 @enderror">
            </div>
            @error('age_min')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('age_max')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="priorite" class="block text-gray-700 font-medium mb-2">Priorité</label>
            <select name="priorite" id="priorite" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('priorite') border-red-500 @enderror">
                <option value="1" {{ old('priorite') == '1' ? 'selected' : '' }}>Basse</option>
                <option value="2" {{ old('priorite', '2') == '2' ? 'selected' : '' }}>Normale</option>
                <option value="3" {{ old('priorite') == '3' ? 'selected' : '' }}>Haute</option>
            </select>
            @error('priorite')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const categorieSection = document.getElementById('categorieSection');
        const ageSection = document.getElementById('ageSection');
        
        function updateSections() {
            const selectedType = typeSelect.value;
            
            categorieSection.classList.add('hidden');
            ageSection.classList.add('hidden');
            
            if (selectedType === 'categorie') {
                categorieSection.classList.remove('hidden');
            } else if (selectedType === 'age') {
                ageSection.classList.remove('hidden');
            }
        }
        
        typeSelect.addEventListener('change', updateSections);
        
        // Initial setup
        updateSections();
    });
</script>
@endpush
@endsection