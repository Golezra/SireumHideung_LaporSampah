<?php

namespace App\Notifications;

use App\Models\LaporSampah;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LaporanDitolakNotification extends Notification
{
    use Queueable;

    protected $laporan;
    protected $alasan;

    /**
     * Create a new notification instance.
     */
    public function __construct(LaporSampah $laporan, $alasan)
    {
        $this->laporan = $laporan;
        $this->alasan = $alasan;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Laporan Anda Ditolak')
            ->line('Laporan Anda dengan ID #' . $this->laporan->id . ' telah ditolak.')
            ->line('Alasan: ' . $this->alasan)
            ->action('Edit Laporan', url('/lapor-sampah/edit/' . $this->laporan->id))
            ->line('Silakan perbaiki laporan Anda sesuai dengan instruksi di atas.')
            ->salutation("Dilan Ariandi, Sireum Hideung");
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'laporan_id' => $this->laporan->id,
            'alasan' => $this->alasan,
            'url' => url('/lapor-sampah/edit/' . $this->laporan->id),
        ];
    }
}
