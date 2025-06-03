@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rapport d'Activité</h1>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Filtre</span>
            <div>
                <form action="{{ route('historiques.rapport') }}" method="GET" class="d-flex">
                    <div class="me-2">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" name="date_debut" id="date_debut" class="form-control" 
                               value="{{ request('date_debut', date('Y-m-d', strtotime('-30 days'))) }}">
                    </div>
                    <div class="me-2">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" name="date_fin" id="date_fin" class="form-control" 
                               value="{{ request('date_fin', date('Y-m-d')) }}">
                    </div>
                    <div class="d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Générer le rapport</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            Résumé
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $nouveauxEmprunts }}</h5>
                            <p class="card-text">Nouveaux emprunts</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $empruntsRetournes }}</h5>
                            <p class="card-text">Emprunts retournés</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $nouveauxUtilisateurs }}</h5>
                            <p class="card-text">Nouveaux utilisateurs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $tauxRetard }}%</h5>
                            <p class="card-text">Taux de retard</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Items les plus empruntés
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Nombre d'emprunts</th>
                                    <th>Disponibilité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($itemsPopulaires as $item)
                                <tr>
                                    <td>{{ $item->nom }}</td>
                                    <td>{{ $item->emprunts_count }}</td>
                                    <td>
                                        @if($item->disponible)
                                            <span class="badge bg-success">Disponible</span>
                                        @else
                                            <span class="badge bg-danger">Indisponible</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Utilisateurs actifs sur la période
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Emprunts</th>
                                    <th>Retours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilisateursActifs as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->nouveaux_emprunts_count }}</td>
                                    <td>{{ $user->emprunts_retournes_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            Évolution quotidienne
        </div>
        <div class="card-body">
            <canvas id="dailyChart" width="100%" height="50"></canvas>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('historiques.export-rapport', request()->query()) }}" class="btn btn-success">
            Exporter en PDF
        </a>
        <a href="{{ route('historiques.export-excel', request()->query()) }}" class="btn btn-info">
            Exporter en Excel
        </a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('dailyChart').getContext('2d');
        var dailyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($graphData['labels']) !!},
                datasets: [
                    {
                        label: 'Emprunts',
                        data: {!! json_encode($graphData['emprunts']) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Retours',
                        data: {!! json_encode($graphData['retours']) !!},
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection