<div class="bg-white rounded-lg shadow p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Recommandations pour vous</h2>
        <a href="{{ route('recommandations.index') }}" class="text-blue-600 hover:underline text-sm">
            Voir tout
        </a>
    </div>
    
    @if(count($recommandations) > 0)
        <div class="space-y-4">
            @foreach($recommandations as $recommandation)
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if($recommandation->livre->image)
                            <img src="{{ asset('storage/' . $recommandation->livre->image) }}" alt="{{ $recommandation->livre->titre }}" class="w-12 h-16 object-cover">
                        @else
                            <div class="w-12 h-16 bg-gray-200 flex items-center justify-center text-gray-500">
                                No img
                            </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <a href="{{ route('livres.show', $recommandation->livre->id) }}" class="font-medium hover:underline">
                            {{ $recommandation->livre->titre }}
                        </a>
                        <p class="text-sm text-gray-600">{{ $recommandation->livre->auteur->nom }}</p>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $recommandation->commentaire }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-4 text-gray-500">
            <p>Aucune recommandation disponible</p>
        </div>
    @endif
</div>