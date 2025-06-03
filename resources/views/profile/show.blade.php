@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Mon Profil</h2>
        
        <div class="mb-6">
            <div class="flex items-center">
                <img class="h-20 w-20 rounded-full object-cover" 
                     src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                     alt="{{ $user->name }}">
                <div class="ml-4">
                    <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="border-t pt-6">
            <a href="{{ route('profile.edit') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition">
                Modifier le profil
            </a>
        </div>
    </div>
</div>
@endsection 