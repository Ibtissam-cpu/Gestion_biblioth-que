@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">Nouvel Emprunt</h3>
        <a href="{{ route('admin.emprunts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.emprunts.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Membre</label>
                <select id="user_id" name="user_id" class="form-select block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Sélectionnez un membre</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="livre_id" class="block text-sm font-medium text-gray-700 mb-2">Livre</label>
                <select id="livre_id" name="livre_id" class="form-select block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Sélectionnez un livre</option>
                    @foreach($livres as $livre)
                        <option value="{{ $livre->id }}" {{ old('livre_id') == $livre->id ? 'selected' : '' }}>
                            {{ $livre->titre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="date_retour_prevue" class="block text-sm font-medium text-gray-700 mb-2">Date de retour prévue</label>
                <input type="date" id="date_retour_prevue" name="date_retour_prevue" 
                       value="{{ old('date_retour_prevue', date('Y-m-d', strtotime('+15 days'))) }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="form-input block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <p class="mt-1 text-sm text-gray-500">La date de retour doit être postérieure à aujourd'hui</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Enregistrer l'emprunt
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 