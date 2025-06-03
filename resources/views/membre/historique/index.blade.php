@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium mb-8">Historique des Emprunts</h3>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-book text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total emprunts</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $statistiques['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-clock text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">En cours</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $statistiques['en_cours'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <i class="fas fa-check-circle text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Retournés</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $statistiques['retournes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">En retard</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $statistiques['en_retard'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des emprunts -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Livre</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date d'emprunt</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date de retour prévue</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($emprunts as $emprunt)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="{{ $emprunt->livre->image ? asset('storage/' . $emprunt->livre->image) : asset('images/default-book.png') }}" 
                                     alt="{{ $emprunt->livre->titre }}"
                                     class="w-10 h-14 object-cover rounded">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $emprunt->livre->titre }}</div>
                                    <div class="text-sm text-gray-500">{{ $emprunt->livre->auteur->nom }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $emprunt->date_emprunt->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $emprunt->date_retour_prevue->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($emprunt->date_retour)
                                @if($emprunt->date_retour > $emprunt->date_retour_prevue)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Retourné en retard
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Retourné à temps
                                    </span>
                                @endif
                            @else
                                @if($emprunt->date_retour_prevue < now())
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        En retard
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        En cours
                                    </span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Aucun emprunt dans l'historique.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50">
            {{ $emprunts->links() }}
        </div>
    </div>
</div>
@endsection 