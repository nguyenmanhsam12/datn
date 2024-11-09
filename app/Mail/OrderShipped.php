<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;  //biến để lưu thông tin đơn hàng
    public $orderAddress;

    /**
     * Create a new message instance.
     */
    public function __construct($order,$orderAddress)
    {
        $this->order = $order; // Gán dữ liệu vào biến $order
        $this->orderAddress = $orderAddress;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME')),
            subject: 'Đơn hàng bạn đã đặt',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'client.mail.order',
            with: [
                'order' => $this->order, // Truyền biến $order vào view
                'orderAddress' => $this->orderAddress,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
