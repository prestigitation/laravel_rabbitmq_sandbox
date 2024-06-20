<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingSuccessMailable extends Mailable
{
    use Queueable, SerializesModels;

    private $qrCode;
    private $image;
    /**
     * Create a new message instance.
     */
    public function __construct(private mixed $flightData)
    {
        $this->image = QrCode::format('png')
                        ->size(200)->errorCorrection('H')
                        ->generate(json_encode($this->flightData));
        $this->qrCode = 'qr-code/img-' . time() . '.png';
        Storage::disk('public')->put($this->qrCode, $this->image);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Бронирование прошло успешно',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.booking.booking_success',
            with: [
                'qrCode' => storage_path('app/public/'.$this->qrCode),
                'flightData' => $this->flightData
                ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path('app/public/'.$this->qrCode))
        ];
    }
}
