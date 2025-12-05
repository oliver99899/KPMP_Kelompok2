<?php

namespace App\Mail;

use App\Models\Review;
use App\Models\Product; // Tambahkan ini
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $review;
    public $product;

    public function __construct(Review $review, Product $product)
    {
        $this->review = $review;
        $this->product = $product;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima Kasih Atas Ulasan Anda - KPMP Market',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.review_submitted',
        );
    }
}