{{-- Champs de formulaire pour la création et l'édition de livres --}}

<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
            <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" 
                value="{{ old('titre', $livre->titre ?? '') }}" required>
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="auteur_id" class="form-label">Auteur <span class="text-danger">*</span></label>
                    <select name="auteur_id" id="auteur_id" class="form-select @error('auteur_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un auteur</option>
                        @foreach($auteurs as $auteur)
                            <option value="{{ $auteur->id }}" {{ (old('auteur_id', $livre->auteur_id ?? '') == $auteur->id) ? 'selected' : '' }}>
                                {{ $auteur->nom }} {{ $auteur->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('auteur_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                    <select name="categorie_id" id="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ (old('categorie_id', $livre->categorie_id ?? '') == $categorie->id) ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="isbn" class="form-label">ISBN <span class="text-danger">*</span></label>
                    <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" 
                        placeholder="978-2-1234-5680-3" value="{{ old('isbn', $livre->isbn ?? '') }}" required>
                    @error('isbn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="annee_publication" class="form-label">Année de publication</label>
                    <input type="number" name="annee_publication" id="annee_publication" 
                        class="form-control @error('annee_publication') is-invalid @enderror" 
                        min="1000" max="{{ date('Y') + 1 }}" 
                        value="{{ old('annee_publication', $livre->annee_publication ?? '') }}">
                    @error('annee_publication')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="nombre_pages" class="form-label">Nombre de pages</label>
                    <input type="number" name="nombre_pages" id="nombre_pages" 
                        class="form-control @error('nombre_pages') is-invalid @enderror" 
                        min="1" value="{{ old('nombre_pages', $livre->nombre_pages ?? '') }}">
                    @error('nombre_pages')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="editeur" class="form-label">Éditeur</label>
                    <input type="text" name="editeur" id="editeur" class="form-control @error('editeur') is-invalid @enderror" 
                        value="{{ old('editeur', $livre->editeur ?? '') }}">
                    @error('editeur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="stock_total" class="form-label">Stock total <span class="text-danger">*</span></label>
                    <input type="number" name="stock_total" id="stock_total" 
                        class="form-control @error('stock_total') is-invalid @enderror" 
                        min="{{ isset($livre) ? ($livre->stock_total - $livre->stock_disponible) : 0 }}" 
                        value="{{ old('stock_total', $livre->stock_total ?? 0) }}" required>
                    @error('stock_total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(isset($livre))
                        <small class="form-text text-muted">
                            Actuellement {{ $livre->stock_disponible }} exemplaire(s) disponible(s) sur {{ $livre->stock_total }}.
                        </small>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="5" 
                class="form-control @error('description') is-invalid @enderror">{{ old('description', $livre->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="image_couverture" class="form-label">Image de couverture</label>
            
            @if(isset($livre) && $livre->image_couverture)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $livre->image_couverture) }}" 
                        alt="Couverture de {{ $livre->titre }}" 
                        class="img-thumbnail mb-2" style="max-height: 200px;">
                </div>
            @endif
            
            <input type="file" name="image_couverture" id="image_couverture" 
                class="form-control @error('image_couverture') is-invalid @enderror" 
                accept="image/*">
            <small class="form-text text-muted">Format recommandé: JPG, PNG. Max 2MB.</small>
            @error('image_couverture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>