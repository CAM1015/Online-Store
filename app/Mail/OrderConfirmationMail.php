<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Crear una nueva instancia del mensaje.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Obtener el sobre del mensaje.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Order Confirmation for Order #' . $this->order->getId(),
        );
    }

    /**
     * Obtener la definición del contenido del mensaje.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.order_confirmation',
            with: [
                'order' => $this->order,
            ]
        );
    }

    /**
     * Obtener los adjuntos para el mensaje.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    /**
     * Enviar una copia del correo al administrador.
     *
     * @return void
     */
    public function build()
    {
        
        $this->to($this->order->user->email)
             ->subject('Order Confirmation for Order #' . $this->order->getId());

        
        $this->cc('claudia@admin.com');

        return $this;
    }
}
