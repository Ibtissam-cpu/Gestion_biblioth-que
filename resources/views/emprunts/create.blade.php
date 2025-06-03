@extends('layouts.app')

@section('title', 'Nouvel Emprunt')
@section('header', 'Nouvel Emprunt')

@section('content')
<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Informations d'emprunt</h3>
            <p class="mt-1 text-sm text-gray-600">
                Veuillez remplir ce formulaire pour enregistrer un nouvel emprunt de livre.
            </p>
            <div class="mt-6 rounded-md bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Rappel</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>
                                La durée d'emprunt standard est de 14 jours. Assurez-vous que le membre est informé de la date de retour prévue.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 md:col-span-2 md:mt-0">
        <form action="{{ route('emprunts.store') }}" method="POST">
            @csrf
            <div class="overflow-hidden shadow sm:rounded-md">
                <div class="bg-white px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="member_id" class="block text-sm font-medium text-gray-700">Membre</label>
                            <select id="member_id" name="member_id" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <option value="">Sélectionnez un membre</option>
                                @foreach($members ?? [] as $member)
                                <option value="{{ $member->id ?? 1 }}">{{ $member->name ?? 'Jean Dupont' }}</option>
                                @endforeach
                            </select>
                            @error('member_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="book_id" class="block text-sm font-medium text-gray-700">Livre</label>
                            <select id="book_id" name="book_id" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <option value="">Sélectionnez un livre</option>
                                @foreach($books ?? [] as $book)
                                <option value="{{ $book->id ?? 1 }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title ?? 'Le Seigneur des Anneaux' }} ({{ $book->author->name ?? 'J.R.R. Tolkien' }})
                                </option>
                                @endforeach
                            </select>
                            @error('book_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="borrowed_at" class="block text-sm font-medium text-gray-700">Date d'emprunt</label>
                            <input type="date" name="borrowed_at" id="borrowed_at" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            @error('borrowed_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Date de retour prévue</label>
                            <input type="date" name="due_date" id="due_date" value="{{ date('Y-m-d', strtotime('+14 days')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                            @error('due_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Informations supplémentaires sur cet emprunt..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                    <a href="{{ route('emprunts.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        Annuler
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
