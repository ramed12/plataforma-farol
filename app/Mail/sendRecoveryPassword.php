<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendRecoveryPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $user;
     protected $password;
    public function __construct(User $user, $password)
    {
        $this->user     = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject("Senha atualizada com sucesso - FAROL");
        $this->to($this->user->email, $this->user->name);
        return $this->view('auth.email.sendRecoveryPassword', [
            "user"     => $this->user,
            "password" => $this->password
        ]);
    }
}
