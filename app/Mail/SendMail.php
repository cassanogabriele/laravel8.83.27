<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orders;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('gabriel_cassano@hotmail.com', 'GC MARKET')
                    ->subject('Votre commande sur GC MARKET,  #: ' . $this->orders->first()->id)
                    ->view('mails.facture')
                    ->with('orders', $this->orders);
    }
}
