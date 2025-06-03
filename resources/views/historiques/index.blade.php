@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isBibliothecaire()))
                            Historique des activités
                        @else
                            Mon historique d'activités
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(Auth::user()->isAdmin() || Auth::user()->isBibliothecaire())
                    <!-- Filtres pour admin/bibliothécaire -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('historiques.index') }}" class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="user_id">Utilisateur</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Tous les utilisateurs</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="action">Action</label>
                                    <select name="action" id="action" class="form-control">
                                        <option value="">Toutes les actions</option>
                                        <option value="emprunt" {{ request('action') == 'emprunt' ? 'selected' : '' }}>Emprunt</option>
                                        <option value="retour" {{ request('action') == 'retour' ? 'selected' : '' }}>Retour</option>
                                        <option value="reservation" {{ request('action') == 'reservation' ? 'selected' : '' }}>Réservation</option>
                                        <option value="annulation" {{ request('action') == 'annulation' ? 'selected' : '' }}>Annulation</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filtrer</button>
                                    <a href="{{ route('historiques.index') }}" class="btn btn-secondary">Réinitialiser</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    @if(!empty($historiques) && count($historiques) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        @if(Auth::user()->isAdmin() || Auth::user()->isBibliothecaire())
                                            <th>Utilisateur</th>
                                        @endif
                                        <th>Livre</th>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historiques as $historique)
                                        <tr>
                                            @if(Auth::user()->isAdmin() || Auth::user()->isBibliothecaire())
                                                <td>
                                                    <a href="{{ route('historiques.user', $historique->user->id) }}">
                                                        {{ $historique->user->name }}
                                                    </a>
                                                </td>
                                            @endif
                                            <td>{{ $historique->livre->titre }}</td>
                                            <td>
                                                @switch($historique->action)
                                                    @case('emprunt')
                                                        <span class="badge bg-primary">Emprunt</span>
                                                        @break
                                                    @case('retour')
                                                        <span class="badge bg-success">Retour</span>
                                                        @break
                                                    @case('reservation')
                                                        <span class="badge bg-warning">Réservation</span>
                                                        @break
                                                    @case('annulation')
                                                        <span class="badge bg-danger">Annulation</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $historique->action }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($historique->date_action)->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($historique->details)
                                                    {{ $historique->details }}
                                                @else
                                                    <span class="text-muted">Aucun détail</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $historiques->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Aucune activité n'a été enregistrée.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection