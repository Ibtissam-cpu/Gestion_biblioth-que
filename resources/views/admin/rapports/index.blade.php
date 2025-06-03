@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Rapports et Statistiques</h1>

    <!-- Statistiques générales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-book text-blue-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total des livres</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalLivres }}</p>
                    <p class="text-sm text-gray-500">{{ $livresDisponibles }} disponibles</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-exchange-alt text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Emprunts en cours</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $empruntsEnCours }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-clock text-red-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Emprunts en retard</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $empruntsEnRetard }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-users text-purple-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total des membres</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalMembres }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Livres les plus empruntés -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Livres les plus empruntés</h2>
            <div class="space-y-4">
                @foreach($livresPopulaires as $livre)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
                    <div class="flex items-center">
                        <div class="bg-gray-200 w-12 h-16 flex items-center justify-center rounded">
                            <i class="fas fa-book text-gray-400"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-800">{{ $livre->titre }}</h4>
                            <p class="text-xs text-gray-500">{{ $livre->auteur }}</p>
                        </div>
                    </div>
                    <div class="text-sm font-medium text-gray-600">
                        {{ $livre->emprunts_count }} emprunt(s)
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Statistiques mensuelles -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistiques mensuelles</h2>
            <div class="space-y-4">
                @foreach($empruntsMensuels as $stat)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
                    <div class="text-sm font-medium text-gray-800">
                        {{ Carbon\Carbon::createFromDate(null, $stat->mois, 1)->format('F Y') }}
                    </div>
                    <div class="text-sm font-medium text-gray-600">
                        {{ $stat->total }} emprunt(s)
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Taux de retard -->
    <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Taux de retard</h2>
        <div class="flex items-center">
            <div class="flex-1 bg-gray-200 rounded-full h-4">
                <div class="bg-red-500 h-4 rounded-full" style="width: {{ $tauxRetardPourcentage }}%"></div>
            </div>
            <span class="ml-4 text-sm font-medium text-gray-600">{{ $tauxRetardPourcentage }}%</span>
        </div>
        <p class="mt-2 text-sm text-gray-500">Pourcentage des emprunts retournés en retard</p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Vous pouvez ajouter ici du code JavaScript pour des graphiques interactifs si nécessaire
</script>
@endpush 