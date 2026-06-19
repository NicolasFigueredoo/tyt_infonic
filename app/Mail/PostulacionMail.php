<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostulacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $mail = $this
            ->subject('Nueva postulación — ' . ($this->data['oferta_id'] ? 'Oferta #' . $this->data['oferta_id'] : 'Base general'))
            ->view('emails.Postulacion')
            ->with($this->data);

        if (!empty($this->data['cv_path'])) {
            $mail->attachFromStorageDisk('public', $this->data['cv_path'], 'CV_' . $this->data['nombre'] . '_' . $this->data['apellido']);
        }

        return $mail;
    }
}
