<div>
    <h2 class="text-xl font-semibold mb-4">Livres similaires</h2>
    
    @if(count($livresSimilaires) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($livresSimilaires as $livre)
            <a href="{{ route('livres.show', $livre->id) }}" class="block bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="h-40 bg-gray-200 overflow-hidden">
                    @if($livre->image)
                        <img src="{{ asset('storage/' . $livre->image) }}" alt="{{ $livre->titre }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500">
                            Pas d'image
                        </div>
                    @endif
                </div>
                <div class="p-3">
                    <h3 class="font-medium text-sm truncate">{{ $livre->titre }}</h3>
                    <p class="text-gray-600 text-xs">{{ $livre->auteur->nom }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xs text-gray-500">{{ $livre->categorie->nom }}</span>
                        @if($livre->disponible)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Disponible</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Emprunté</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50 p-4 rounded-lg text-center text-gray-500">
            <p>Aucun livre similaire trouvé</p>
        </div>
    @endif
</div>