<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Livre;

class LivreDisponibleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $livre;

    public function __construct(Livre $livre)
    {
        $this->livre = $livre;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Un livre que vous attendiez est disponible')
            ->line('Le livre "' . $this->livre->titre . '" est maintenant disponible.')
            ->line('Auteur : ' . $this->livre->auteur->nom)
            ->line('Vous pouvez maintenant l\'emprunter.')
            ->action('Voir le livre', route('livres.show', $this->livre));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Le livre "' . $this->livre->titre . '" est maintenant disponible.',
            'livre_id' => $this->livre->id,
            'auteur' => $this->livre->auteur->nom
        ];
    }
} 