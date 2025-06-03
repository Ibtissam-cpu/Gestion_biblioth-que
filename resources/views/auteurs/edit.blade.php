@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Modifier l'auteur</h5>
                    <a href="{{ route('auteurs.index') }}" class="btn btn-secondary btn-sm">
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

                    <form action="{{ route('auteurs.update', $auteur->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group row mb-3">
                            <label for="nom" class="col-md-4 col-form-label text-md-right">Nom *</label>
                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom', $auteur->nom) }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="prenom" class="col-md-4 col-form-label text-md-right">Prénom *</label>
                            <div class="col-md-6">
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom', $auteur->prenom) }}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="date_naissance" class="col-md-4 col-form-label text-md-right">Date de naissance</label>
                            <div class="col-md-6">
                                <input id="date_naissance" type="date" class="form-control @error('date_naissance') is-invalid @enderror" name="date_naissance" value="{{ old('date_naissance', $auteur->date_naissance ? $auteur->date_naissance->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="date_deces" class="col-md-4 col-form-label text-md-right">Date de décès</label>
                            <div class="col-md-6">
                                <input id="date_deces" type="date" class="form-control @error('date_deces') is-invalid @enderror" name="date_deces" value="{{ old('date_deces', $auteur->date_deces ? $auteur->date_deces->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="nationalite" class="col-md-4 col-form-label text-md-right">Nationalité</label>
                            <div class="col-md-6">
                                <input id="nationalite" type="text" class="form-control @error('nationalite') is-invalid @enderror" name="nationalite" value="{{ old('nationalite', $auteur->nationalite) }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="biographie" class="col-md-4 col-form-label text-md-right">Biographie</label>
                            <div class="col-md-6">
                                <textarea id="biographie" class="form-control @error('biographie') is-invalid @enderror" name="biographie" rows="4">{{ old('biographie', $auteur->biographie) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>
                            <div class="col-md-6">
                                @if($auteur->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $auteur->photo) }}" alt="{{ $auteur->nom }}" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input id="photo" type="file" class="form-control-file @error('photo') is-invalid @enderror" name="photo">
                                <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle</small>
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