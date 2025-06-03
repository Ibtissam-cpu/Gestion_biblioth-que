@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        @if($categorie->icone)
                            <i class="fas {{ $categorie->icone }}" style="color: {{ $categorie->couleur ?? '#3490dc' }}"></i>
                        @endif
                        Catégorie : {{ $categorie->nom }}
                    </h5>
                    <div>
                        <a href="{{ route('categories.edit', $categorie->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
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

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Informations sur la catégorie</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-8">
                                            @if($categorie->description)
                                                <p class="mb-3"><strong>Description :</strong> {{ $categorie->description }}</p>
                                            @endif
                                            
                                            <p class="mb-3"><strong>Nombre de livres :</strong> {{ $categorie->livres->count() }}</p>
                                        </div>
                                        
                                        <div class="col-md-4 text-center">
                                            @if($categorie->couleur)
                                                <div class="p-3 rounded shadow-sm" style="background-color: {{ $categorie->couleur }}">
                                                    <span class="text-white">Couleur de la catégorie</span>
                                                </div>
                                            @endif
                                            
                                            @if($categorie->icone)
                                                <div class="mt-3">
                                                    <i class="fas {{ $categorie->icone }} fa-3x" style="color: {{ $categorie->couleur ?? '#3490dc' }}"></i>
                                                    <p class="mt-2">Icône: {{ $categorie->icone }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liste des livres de cette catégorie -->
                    <div>
                        <h5>Livres dans cette catégorie ({{ $categorie->livres->count() }})</h5>
                        
                        @if($categorie->livres->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Auteur</th>
                                            <th>Année</th>
                                            <th>ISBN</th>
                                            <th>Disponibilité</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categorie->livres as $livre)
                                            <tr>
                                                <td>{{ $livre->titre }}</td>
                                                <td>
                                                    @if($livre->auteur)
                                                        <a href="{{ route('auteurs.show', $livre->auteur->id) }}">
                                                            {{ $livre->auteur->prenom }} {{ $livre->auteur->nom }}
                                                        </a>
                                                    @else
                                                        Non spécifié
                                                    @endif
                                                </td>
                                                <td>{{ $livre->annee_publication }}</td>
                                                <td>{{ $livre->isbn }}</td>
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
                                Aucun livre trouvé dans cette catégorie.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection