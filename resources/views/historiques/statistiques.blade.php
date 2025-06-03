@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Statistiques des Utilisateurs</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total des utilisateurs</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalUsers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total des emprunts</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalEmprunts }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Emprunts en cours</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $empruntsEnCours }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Emprunts en retard</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $empruntsEnRetard }}</h5>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Utilisateurs les plus actifs
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Nombre d'emprunts</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilisateursActifs as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->emprunts_count }}</td>
                                    <td>
                                        <a href="{{ route('historiques.show', $user) }}" class="btn btn-sm btn-primary">Voir l'historique</a>
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
                    Utilisateurs avec emprunts en retard
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Nombre d'emprunts en retard</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilisateursEnRetard as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->emprunts_en_retard_count }}</td>
                                    <td>
                                        <a href="{{ route('historiques.show', $user) }}" class="btn btn-sm btn-primary">Voir l'historique</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            Activité mensuelle
        </div>
        <div class="card-body">
            <canvas id="activityChart" width="100%" height="50"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('activityChart').getContext('2d');
        var activityChart = new Chart(ctx, {
            type: 'line',
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