@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1>Ajouter un livre</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('livres.index') }}">Livres</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('livres.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="auteur_id" class="form-label">Auteur <span class="text-danger">*</span></label>
                                <select class="form-select @error('auteur_id') is-invalid @enderror" id="auteur_id" name="auteur_id" required>
                                    <option value="">Sélectionner un auteur</option>
                                    @foreach($auteurs as $auteur)
                                        <option value="{{ $auteur->id }}" {{ old('auteur_id') == $auteur->id ? 'selected' : '' }}>
                                            {{ $auteur->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('auteur_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id" name="categorie_id" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="isbn" class="form-label">ISBN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="annee_publication" class="form-label">Année de publication</label>
                                <input type="number" class="form-control @error('annee_publication') is-invalid @enderror" id="annee_publication" name="annee_publication" value="{{ old('annee_publication') }}" min="1000" max="{{ date('Y') + 1 }}">
                                @error('annee_publication')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editeur" class="form-label">Éditeur</label>
                                <input type="text" class="form-control @error('editeur') is-invalid @enderror" id="editeur" name="editeur" value="{{ old('editeur') }}">
                                @error('editeur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nombre_pages" class="form-label">Nombre de pages</label>
                                <input type="number" class="form-control @error('nombre_pages') is-invalid @enderror" id="nombre_pages" name="nombre_pages" value="{{ old('nombre_pages') }}" min="1">
                                @error('nombre_pages')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="stock_total" class="form-label">Stock total <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock_total') is-invalid @enderror" id="stock_total" name="stock_total" value="{{ old('stock_total', 1) }}" min="0" required>
                            @error('stock_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image_couverture" class="form-label">Image de couverture</label>
                            <input type="file" class="form-control @error('image_couverture') is-invalid @enderror" id="image_couverture" name="image_couverture" accept="image/*">
                            <small class="form-text text-muted">Format JPG, PNG ou GIF. Max 2Mo.</small>
                            @error('image_couverture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="mt-3 text-center" id="image-preview-container">
                                <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="height: 200px; width: 150px; margin: 0 auto;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('livres.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Aperçu de l'image
    document.getElementById('image_couverture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('image-preview-container');
                container.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px; max-width: 150px;" alt="Aperçu de la couverture">
                `;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection