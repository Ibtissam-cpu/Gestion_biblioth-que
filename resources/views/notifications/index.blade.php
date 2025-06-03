@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <h3 class="text-gray-700 text-3xl font-medium">Notifications</h3>
        @if($notifications->where('read_at', null)->count() > 0)
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-150">
                    Tout marquer comme lu
                </button>
            </form>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @forelse($notifications as $notification)
            <div class="p-6 border-b {{ $notification->read_at ? 'bg-gray-50' : 'bg-white' }}">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if($notification->type === 'App\Notifications\EmpruntRetardNotification')
                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-red-600"></i>
                            </div>
                        @elseif($notification->type === 'App\Notifications\EmpruntRappelNotification')
                            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                        @elseif($notification->type === 'App\Notifications\LivreDisponibleNotification')
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-bell text-blue-600"></i>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $notification->data['message'] }}
                            </p>
                            <div class="ml-4 flex-shrink-0 flex">
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800">
                                            Marquer comme lu
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">
                Aucune notification.
            </div>
        @endforelse

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection