@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Modifier la catégorie</h5>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('categories.update', $categorie->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group row mb-3">
                            <label for="nom" class="col-md-4 col-form-label text-md-right">Nom *</label>
                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom', $categorie->nom) }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $categorie->description) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="couleur" class="col-md-4 col-form-label text-md-right">Couleur</label>
                            <div class="col-md-6">
                                <input id="couleur" type="color" class="form-control @error('couleur') is-invalid @enderror" name="couleur" value="{{ old('couleur', $categorie->couleur ?? '#3490dc') }}">
                                <small class="form-text text-muted">Choisissez une couleur pour identifier cette catégorie</small>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="icone" class="col-md-4 col-form-label text-md-right">Icône</label>
                            <div class="col-md-6">
                                <input id="icone" type="text" class="form-control @error('icone') is-invalid @enderror" name="icone" value="{{ old('icone', $categorie->icone) }}" placeholder="fa-book">
                                <small class="form-text text-muted">Nom de l'icône FontAwesome (ex: fa-book)</small>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection