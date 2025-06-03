<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Emprunt;

class EmpruntRetardNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $emprunt;

    public function __construct(Emprunt $emprunt)
    {
        $this->emprunt = $emprunt;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Retard de retour de livre')
            ->line('Votre emprunt du livre "' . $this->emprunt->livre->titre . '" est en retard.')
            ->line('La date de retour était prévue pour le ' . $this->emprunt->date_retour_prevue->format('d/m/Y') . '.')
            ->line('Veuillez retourner le livre dès que possible pour éviter des pénalités supplémentaires.')
            ->action('Voir mes emprunts', route('historique.index'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Votre emprunt du livre "' . $this->emprunt->livre->titre . '" est en retard.',
            'emprunt_id' => $this->emprunt->id,
            'livre_id' => $this->emprunt->livre_id,
            'date_retour_prevue' => $this->emprunt->date_retour_prevue->format('Y-m-d'),
        ];
    }
} 