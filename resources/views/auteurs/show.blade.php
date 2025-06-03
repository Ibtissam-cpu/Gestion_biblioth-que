@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Détails de l'auteur</h5>
                    <div>
                        <a href="{{ route('auteurs.edit', $auteur->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('auteurs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Photo de l'auteur -->
                        <div class="col-md-3 text-center mb-4">
                            @if($auteur->photo)
                                <img src="{{ asset('storage/' . $auteur->photo) }}" alt="{{ $auteur->nom }}" class="img-fluid rounded shadow">
                            @else
                                <div class="bg-light rounded p-4 d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-user fa-4x text-secondary"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Informations sur l'auteur -->
                        <div class="col-md-9">
                            <h3>{{ $auteur->prenom }} {{ $auteur->nom }}</h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 40%">Nationalité:</th>
                                            <td>{{ $auteur->nationalite ?? 'Non spécifiée' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Né(e) le:</th>
                                            <td>{{ $auteur->date_naissance ? $auteur->date_naissance->format('d/m/Y') : 'Non spécifiée' }}</td>
                                        </tr>
                                        @if($auteur->date_deces)
                                        <tr>
                                            <th>Décédé(e) le:</th>
                                            <td>{{ $auteur->date_deces->format('d/m/Y') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            
                            @if($auteur->biographie)
                                <div class="mt-3">
                                    <h5>Biographie</h5>
                                    <div class="p-3 bg-light rounded">
                                        {!! nl2br(e($auteur->biographie)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Liste des livres de l'auteur -->
                    <div class="mt-4">
                        <h5>Livres par cet auteur ({{ $auteur->livres->count() }})</h5>
                        
                        @if($auteur->livres->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Catégorie</th>
                                            <th>Année</th>
                                            <th>Disponibilité</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auteur->livres as $livre)
                                            <tr>
                                                <td>{{ $livre->titre }}</td>
                                                <td>{{ $livre->categorie->nom ?? 'Non catégorisé' }}</td>
                                                <td>{{ $livre->annee_publication }}</td>
                                                <td>
                                                    @if($livre->disponible)
                                                        <span class="badge bg-success">Disponible</span>
                                                    @else
                                                        <span class="badge bg-danger">Emprunté</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('livres.show', $livre->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Aucun livre trouvé pour cet auteur.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection