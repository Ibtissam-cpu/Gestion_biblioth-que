@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Détails de l'emprunt #{{ $emprunt->id }}</h5>
                    <div>
                        <a href="{{ route('emprunts.index') }}" class="btn btn-secondary btn-sm">
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
                        <!-- Informations sur l'emprunt -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Informations sur l'emprunt</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Date d'emprunt:</span>
                                            <strong>{{ $emprunt->date_emprunt->format('d/m/Y') }}</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Date de retour prévue:</span>
                                            <strong>{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Statut:</span>
                                            @if ($emprunt->date_retour)
                                                <span class="badge bg-success">Retourné le {{ $emprunt->date_retour->format('d/m/Y') }}</span>
                                            @elseif ($emprunt->est_en_retard)
                                                <span class="badge bg-danger">En retard ({{ $emprunt->jours_retard }} jours)</span>
                                            @else
                                                <span class="badge bg-primary">En cours</span>
                                            @endif
                                        </li>
                                        @if ($emprunt->commentaire)
                                            <li class="list-group-item">
                                                <span>Commentaire:</span>
                                                <p class="mt-1 mb-0">{{ $emprunt->commentaire }}</p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Informations sur le lecteur -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Informations sur le lecteur</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <span>Nom:</span>
                                            <strong>{{ $emprunt->lecteur->nom }} {{ $emprunt->lecteur->prenom }}</strong>
                                        </li>
                                        <li class="list-group-item">
                                            <span>Email:</span>
                                            <strong>{{ $emprunt->lecteur->email }}</strong>
                                        </li>
                                        <li class="list-group-item">
                                            <span>Téléphone:</span>
                                            <strong>{{ $emprunt->lecteur->telephone ?? 'Non renseigné' }}</strong>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ route('lecteurs.show', $emprunt->lecteur) }}" class="btn btn-sm btn-outline-primary">
                                                Voir le profil complet
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations sur le livre -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Informations sur le livre</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ $emprunt->livre->image_couverture ?? asset('images/default_book.jpg') }}" 
                                         alt="Couverture du livre" class="img-fluid rounded">
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $emprunt->livre->titre }}</h5>
                                    <p class="mb-1">
                                        <strong>Auteur:</strong> {{ $emprunt->livre->auteur->nom }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Catégorie:</strong> {{ $emprunt->livre->categorie->nom }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>ISBN:</strong> {{ $emprunt->livre->isbn }}
                                    </p>
                                    <p class="mb-3">
                                        <strong>Année de publication:</strong> {{ $emprunt->livre->annee_publication }}
                                    </p>
                                    <a href="{{ route('livres.show', $emprunt->livre) }}" class="btn btn-sm btn-outline-primary">
                                        Voir les détails du livre
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 d-flex justify-content-between">
                        @if (!$emprunt->date_retour)
                            <div>
                                <a href="{{ route('emprunts.edit', $emprunt) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form action="{{ route('emprunts.retour', $emprunt) }}" method="POST" class="d-inline ml-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Confirmer le retour de ce livre?')">
                                        <i class="fas fa-undo"></i> Marquer comme retourné
                                    </button>
                                </form>
                            </div>
                        @else
                            <div>
                                <span class="text-success">
                                    <i class="fas fa-check-circle"></i> Cet emprunt est terminé
                                </span>
                            </div>
                        @endif

                        <form action="{{ route('emprunts.destroy', $emprunt) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet emprunt?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection