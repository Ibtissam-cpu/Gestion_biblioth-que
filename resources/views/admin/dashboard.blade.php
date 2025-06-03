@extends('layouts.admin')

@section('title', 'Tableau de bord Admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
        <div class="flex space-x-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-download mr-2"></i> Exporter les statistiques
            </button>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Utilisateurs</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalUsers }}</p>
                </div>
                <div class="p-3 bg-blue-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="{{ $userGrowth >= 0 ? 'text-green-500' : 'text-red-500' }} mr-2">
                    <i class="fas {{ $userGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> {{ abs($userGrowth) }}%
                </span>
                <span class="text-gray-500">Depuis le mois dernier</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Emprunts Actifs</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $activeLoans }}</p>
                </div>
                <div class="p-3 bg-green-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-book-reader text-green-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="{{ $loanGrowth >= 0 ? 'text-green-500' : 'text-red-500' }} mr-2">
                    <i class="fas {{ $loanGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> {{ abs($loanGrowth) }}%
                </span>
                <span class="text-gray-500">Depuis la semaine dernière</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Retards</p>
                    <p class="text-2xl font-semibold text-red-600">{{ $lateLoans ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-clock text-red-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-red-500 mr-2">
                    <i class="fas fa-exclamation-circle"></i> À traiter
                </span>
                <span class="text-gray-500">Emprunts en retard</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Livres Disponibles</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $availableBooks }}</p>
                </div>
                <div class="p-3 bg-purple-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-book text-purple-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Sur {{ $totalBooks }} livres</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Graphique des emprunts -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Activité des emprunts (7 derniers jours)</h3>
            <div class="h-80">
                <canvas id="loansChart"></canvas>
            </div>
        </div>

        <!-- Livres les plus empruntés -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 5 des livres les plus empruntés</h3>
            <div class="space-y-4">
                @forelse($topBooks as $book)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
                    <div class="flex items-center">
                        <div class="bg-gray-200 w-12 h-16 flex items-center justify-center rounded">
                            <i class="fas fa-book text-gray-400"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-800">{{ $book->titre ?? 'Titre inconnu' }}</h4>
                            <p class="text-xs text-gray-500">{{ $book->auteur ?? 'Auteur inconnu' }}</p>
                        </div>
                    </div>
                    <div class="text-sm font-medium text-gray-600">
                        {{ $book->loans_count ?? 0 }} emprunt(s)
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Aucun livre emprunté récemment</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Dernières activités -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Activités récentes</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentActivities as $activity)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600">{{ substr($activity->user->name ?? 'A', 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $activity->user->name ?? 'Utilisateur inconnu' }}</div>
                                        <div class="text-sm text-gray-500">{{ $activity->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $activity->action }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($activity->details, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $activity->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($activity->status === 'success')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Succès
                                </span>
                                @elseif($activity->status === 'failed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Échec
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    En attente
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucune activité récente
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('loansChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($loanChartLabels),
            datasets: [{
                label: 'Nombre d\'emprunts',
                data: @json($loanChartData),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection