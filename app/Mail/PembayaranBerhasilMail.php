<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PembayaranBerhasilMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $laporan;

    public function __construct($user, $laporan)
    {
        $this->user = $user;
        $this->laporan = $laporan;
    }

    public function build()
    {
        return $this->subject('Pembayaran Berhasil')
            ->view('emails.pembayaran-berhasil');
    }
}
