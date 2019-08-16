<?php

namespace App\Mail;

use App\User;
use App\Chamado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChamadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $chamado;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Chamado $chamado, User $user)
    {
        $this->chamado = $chamado;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.chamado')
                    ->from(config('sites.email_principal'))
                    ->to([config('sites.email_principal'),$this->user->email])
                    ->subject("Novo chamado para o site: {$this->chamado->site->dominio}" . config('sites.dnszone'));
    }
}
