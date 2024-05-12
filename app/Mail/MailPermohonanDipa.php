<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPermohonanDipa extends Mailable
{
    use Queueable, SerializesModels;

    public $dipa;

    public function __construct($dipa)
    {
        $this->dipa = $dipa;
    }


    public function build()
    {
        return $this->view('emails.permohonanDipa')
            ->subject('Permohonan Dipa | e-Planing IAIN SAS BABEL') // Menetapkan subjek email di sini
            ->with([
                'dipa' => $this->dipa,
            ]);
    }
}
