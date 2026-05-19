<?php

namespace App\Mail;

use App\Models\Authorization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class PortariaNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Authorization $authorization;

    public function __construct(Authorization $authorization)
    {
        $this->authorization = $authorization;
    }

    public function build()
    {
        return $this->subject('Confirmação SAFE de entrada/saída')
            ->view('emails.portaria_notification')
            ->with(['authorization' => $this->authorization]);
    }
}
