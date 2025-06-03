<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Emprunt;

class EmpruntRappelNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $emprunt;
    protected $joursRestants;

    public function __construct(Emprunt $emprunt, $joursRestants)
    {
        $this->emprunt = $emprunt;
        $this->joursRestants = $joursRestants;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Rappel de retour de livre')
            ->line('Votre emprunt du livre "' . $this->emprunt->livre->titre . '" arrive bientôt à échéance.')
            ->line('Il vous reste ' . $this->joursRestants . ' jour(s) pour retourner le livre.')
            ->line('Date de retour prévue : ' . $this->emprunt->date_retour_prevue->format('d/m/Y'))
            ->action('Voir mes emprunts', route('historique.index'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Rappel : Il vous reste ' . $this->joursRestants . ' jour(s) pour retourner le livre "' . $this->emprunt->livre->titre . '".',
            'emprunt_id' => $this->emprunt->id,
            'livre_id' => $this->emprunt->livre_id,
            'date_retour_prevue' => $this->emprunt->date_retour_prevue->format('Y-m-d'),
            'jours_restants' => $this->joursRestants
        ];
    }
} 