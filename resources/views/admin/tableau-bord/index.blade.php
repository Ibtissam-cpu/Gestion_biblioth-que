@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tableau de Bord</h1>

    <!-- Statistiques générales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Utilisateurs</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalUsers }}</p>
                    <p class="text-sm text-{{ $userGrowth >= 0 ? 'green' : 'red' }}-500">
                        {{ $userGrowth >= 0 ? '+' : '' }}{{ number_format($userGrowth, 1) }}% ce mois
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-book text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Livres</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalBooks }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $availableBooks }} disponibles
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-exchange-alt text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Emprunts Actifs</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $activeLoans }}</p>
                    <p class="text-sm text-{{ $loanGrowth >= 0 ? 'green' : 'red' }}-500">
                        {{ $loanGrowth >= 0 ? '+' : '' }}{{ number_format($loanGrowth, 1) }}% cette semaine
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-500 bg-opacity-10 rounded-full">
                    <i class="fas fa-clock text-red-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Retards</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $lateLoans }}</p>
                    <p class="text-sm text-gray-500">
                        à suivre
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Livres populaires -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Livres les plus empruntés</h2>
        <div class="space-y-4">
            @foreach($topBooks as $book)
            <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-book text-blue-500"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">{{ $book->titre }}</h3>
                        <p class="text-sm text-gray-500">{{ $book->auteur }}</p>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-600">
                    {{ $book->emprunts_count }} emprunts actifs
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 