@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Détails de l'activité #{{ $historique->id }}</h5>
                    <a href="{{ route('historiques.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Informations sur l'activité</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>ID:</span>
                                            <strong>{{ $historique->id }}</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Date et heure:</span>
                                            <strong>{{ $historique->created_at->format('d/m/Y H:i:s') }}</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Type:</span>
                                            <strong>
                                                @switch($historique->type)
                                                    @case('emprunt')
                                                        <span class="badge bg-primary">Emprunt</span>
                                                        @break
                                                    @case('retour')
                                                        <span class="badge bg-success">Retour</span>
                                                        @break
                                                    @case('livre')
                                                        <span class="badge bg-info">Livre</span>
                                                        @break
                                                    @case('lecteur')
                                                        <span class="badge bg-warning">Lecteur</span>
                                                        @break
                                                    @case('utilisateur')
                                                        <span class="badge bg-dark">Utilisateur</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $historique->type }}</span>
                                                @endswitch
                                            </strong>
                                        </li>
                                        <li class="list-group-item">
                                            <span>Description:</span>
                                            <p class="mt-2 mb-0">{{ $historique->description }}</p>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Utilisateur:</span>
                                            <strong>{{ $historique->user->name ?? 'Système' }}</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Adresse IP:</span>
                                            <strong>{{ $historique->ip_address ?? 'Non enregistrée' }}</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @if ($historique->model_type && $historique->model_id)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Élément concerné</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Type d'élément:</span>
                                                <strong>{{ class_basename($historique->model_type) }}</strong>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>ID de l'élément:</span>
                                                <strong>{{ $historique->model_id }}</strong>
                                            </li>
                                            @if ($element)
                                                <li class="list-group-item">
                                                    <a href="{{ route('historiques.element', ['type' => $historique->model_type, 'id' => $historique->model_id]) }}" class="btn btn-outline-primary">
                                                        Voir l'élément concerné
                                                    </a>
                                                </li>
                                            @else
                                                <li class="list-group-item text-danger">
                                                    <i class="fas fa-exclamation-triangle"></i> Cet élément n'existe plus dans la base de données.
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            @if ($historique->data)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Données de l'activité</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="accordion" id="dataAccordion">
                                            @if (isset($historique->data['before']))
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingBefore">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBefore" aria-expanded="false" aria-controls="collapseBefore">
                                                            État avant modification
                                                        </button>
                                                    </h2>
                                                    <div id="collapseBefore" class="accordion-collapse collapse" aria-labelledby="headingBefore" data-bs-parent="#dataAccordion">
                                                        <div class="accordion-body">
                                                            <pre class="bg-light p-3 rounded"><code>{{ json_encode($historique->data['before'], JSON_PRETTY_PRINT) }}</code></pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (isset($historique->data['after']))
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingAfter">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAfter" aria-expanded="false" aria-controls="collapseAfter">
                                                            État après modification
                                                        </button>
                                                    </h2>
                                                    <div id="collapseAfter" class="accordion-collapse collapse" aria-labelledby="headingAfter" data-bs-parent="#dataAccordion">
                                                        <div class="accordion-body">
                                                            <pre class="bg-light p-3 rounded"><code>{{ json_encode($historique->data['after'], JSON_PRETTY_PRINT) }}</code></pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (isset($historique->data['changes']))
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingChanges">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseChanges" aria-expanded="true" aria-controls="collapseChanges">
                                                            Changements effectués
                                                        </button>
                                                    </h2>
                                                    <div id="collapseChanges" class="accordion-collapse collapse show" aria-labelledby="headingChanges" data-bs-parent="#dataAccordion">
                                                        <div class="accordion-body">
                                                            <table class="table table-striped table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Champ</th>
                                                                        <th>Avant</th>
                                                                        <th>Après</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($historique->data['changes'] as $field => $change)
                                                                        <tr>
                                                                            <td><strong>{{ $field }}</strong></td>
                                                                            <td class="text-danger">{{ is_array($change['old']) ? json_encode($change['old']) : $change['old'] }}</td>
                                                                            <td class="text-success">{{ is_array($change['new']) ? json_encode($change['new']) : $change['new'] }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!isset($historique->data['before']) && !isset($historique->data['after']) && !isset($historique->data['changes']))
                                                <div class="alert alert-info">
                                                    <pre class="mb-0"><code>{{ json_encode($historique->data, JSON_PRETTY_PRINT) }}</code></pre>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Activités liées -->
                    @if ($activitesLiees->count() > 0)
                        <div class="mt-4">
                            <h6>Activités liées au même élément</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activitesLiees as $activite)
                                            <tr class="{{ $activite->id == $historique->id ? 'table-active' : '' }}">
                                                <td>{{ $activite->id }}</td>
                                                <td>{{ $activite->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @switch($activite->type)
                                                        @case('emprunt')
                                                            <span class="badge bg-primary">Emprunt</span>
                                                            @break
                                                        @case('retour')
                                                            <span class="badge bg-success">Retour</span>
                                                            @break
                                                        @case('livre')
                                                            <span class="badge bg-info">Livre</span>
                                                            @break
                                                        @case('lecteur')
                                                            <span class="badge bg-warning">Lecteur</span>
                                                            @break
                                                        @case('utilisateur')
                                                            <span class="badge bg-dark">Utilisateur</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">{{ $activite->type }}</span>
                                                    @endswitch
                                                </td>
                                                <td>{{ $activite->description }}</td>
                                                <td>
                                                    @if ($activite->id != $historique->id)
                                                        <a href="{{ route('historiques.show', $activite) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @else
                                                        <span class="badge bg-secondary">Actuel</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection