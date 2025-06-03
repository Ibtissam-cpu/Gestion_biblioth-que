@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Profil Utilisateur</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informations de l'utilisateur -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">Informations personnelles</div>
                                <div class="card-body">
                                    <p><strong>Nom:</strong> {{ $user->name }}</p>
                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                    <p><strong>Inscrit depuis:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                                    <p><strong>Dernière connexion:</strong> {{ $user->last_login ?? 'Jamais' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Statistiques rapides de l'utilisateur -->
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">Statistiques rapides</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center mb-3">
                                            <h4>{{ $stats->total_entries ?? 0 }}</h4>
                                            <p>Entrées totales</p>
                                        </div>
                                        <div class="col-md-4 text-center mb-3">
                                            <h4>{{ $stats->entries_this_month ?? 0 }}</h4>
                                            <p>Ce mois</p>
                                        </div>
                                        <div class="col-md-4 text-center mb-3">
                                            <h4>{{ $stats->average_per_day ?? 0 }}</h4>
                                            <p>Moyenne/jour</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('historique.statistiques', ['user_id' => $user->id]) }}" class="btn btn-primary btn-sm float-end">Voir toutes les statistiques</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historique récent de l'utilisateur -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Historique récent</span>
                                <a href="{{ route('historique.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-outline-primary">Voir tout l'historique</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($recentHistory) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Action</th>
                                                <th>Détails</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentHistory as $entry)
                                                <tr>
                                                    <td>{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $entry->action }}</td>
                                                    <td>{{ Str::limit($entry->details, 50) }}</td>
                                                    <td>
                                                        <a href="{{ route('historique.show', $entry->id) }}" class="btn btn-sm btn-info">Détails</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center">Aucun historique récent disponible.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Section de visualisation graphique (lien avec statistiques.blade.php) -->
                    <div class="card mt-4">
                        <div class="card-header">Aperçu des tendances</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-center">Activité sur les 7 derniers jours</h5>
                                    <canvas id="weeklyActivityChart" height="200"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-center">Répartition par type d'action</h5>
                                    <canvas id="actionTypeChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('historique.rapport', ['user_id' => $user->id]) }}" class="btn btn-secondary">Générer un rapport complet</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique d'activité hebdomadaire
        const weeklyCtx = document.getElementById('weeklyActivityChart').getContext('2d');
        const weeklyChart = new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($weeklyStats->labels ?? []) !!},
                datasets: [{
                    label: 'Nombre d\'actions',
                    data: {!! json_encode($weeklyStats->data ?? []) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    tension: 0.4
                }]
            },
            options: {
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

        // Graphique de répartition par type d'action
        const typeCtx = document.getElementById('actionTypeChart').getContext('2d');
        const typeChart = new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($actionStats->labels ?? []) !!},
                datasets: [{
                    data: {!! json_encode($actionStats->data ?? []) !!},
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    });
</script>
@endsection