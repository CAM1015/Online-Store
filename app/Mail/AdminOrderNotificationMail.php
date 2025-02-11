<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminOrderNotificationMail extends Mailable
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
            subject: 'New Order Notification for Order #' . $this->order->getId(),
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
            view: 'emails.admin_order_notification',
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
     * Construir el mensaje con el destinatario del administrador.
     *
     * @return void
     */
    public function build()
    {
        // Enviar el correo al administrador
        $this->to('claudia@admin.com')
             ->subject('New Order Notification for Order #' . $this->order->getId());

        return $this;
    }
}
