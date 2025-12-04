<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $seller; // Variabel untuk menampung data penjual

    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Toko Anda Telah Disetujui',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.seller_approved', // Kita akan buat view ini sebentar lagi
        );
    }
}