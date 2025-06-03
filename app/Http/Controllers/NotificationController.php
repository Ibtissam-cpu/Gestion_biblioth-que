<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function show(Notification $notification)
    {
        // Vérifier que l'utilisateur actuel est le destinataire
        if (Auth::id() !== $notification->user_id) {
            abort(403);
        }
        
        // Marquer comme lu
        if (!$notification->lu) {
            $notification->marquerCommeLu();
        }
        
        return view('notifications.show', compact('notification'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    public function destroy(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id) {
            abort(403);
        }
        
        $notification->delete();
        
        return redirect()->route('notifications.index')
            ->with('success', 'Notification supprimée avec succès.');
    }
}
