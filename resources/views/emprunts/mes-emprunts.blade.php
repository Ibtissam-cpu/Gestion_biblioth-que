@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes Emprunts</h1>
    
    <div class="mb-3">
        <a href="{{ route('emprunts.create') }}" class="btn btn-primary">Nouvel emprunt</a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            Mes emprunts en cours
        </div>
        <div class="card-body">
            @if($emprunts->where('statut', 'en_cours')->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Date d'emprunt</th>
                                <th>Date de retour prévue</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emprunts->where('statut', 'en_cours') as $emprunt)
                            <tr class="{{ $emprunt->estEnRetard() ? 'table-danger' : '' }}">
                                <td>{{ $emprunt->item->nom }}</td>
                                <td>{{ $emprunt->date_emprunt->format('d/m/Y') }}</td>
                                <td>{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</td>
                                <td>
                                    @if($emprunt->estEnRetard())
                                        <span class="badge bg-danger">En retard</span>
                                    @else
                                        <span class="badge bg-info">En cours</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('emprunts.show', $emprunt) }}" class="btn btn-sm btn-info">Détails</a>
                                        
                                        <form action="{{ route('emprunts.retourner', $emprunt) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Confirmez-vous le retour de cet élément?')">Retourner</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Vous n'avez aucun emprunt en cours.</p>
            @endif
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            Historique des emprunts
        </div>
        <div class="card-body">
            @if($emprunts->where('statut', 'retourné')->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Date d'emprunt</th>
                                <th>Date de retour</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emprunts->where('statut', 'retourné') as $emprunt)
                            <tr>
                                <td>{{ $emprunt->item->nom }}</td>
                                <td>{{ $emprunt->date_emprunt->format('d/m/Y') }}</td>
                                <td>{{ $emprunt->date_retour_effective->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('emprunts.show', $emprunt) }}" class="btn btn-sm btn-info">Détails</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Vous n'avez aucun historique d'emprunt.</p>
            @endif
        </div>
    </div>
    
    {{ $emprunts->links() }}
</div>
@endsection