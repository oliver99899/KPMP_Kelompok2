<!DOCTYPE html>
<html>
<head>
    <title>Terima Kasih</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="text-align: center; padding: 20px;">
        <h2 style="color: #4F46E5;">Terima Kasih, {{ $review->visitor_name }}!</h2>
        <p>Kami telah menerima ulasan Anda untuk produk:</p>
        <h3>{{ $product->name }}</h3>
        
        <div style="background: #f3f4f6; padding: 15px; border-radius: 10px; display: inline-block; margin: 10px 0;">
            <p style="font-size: 24px; margin: 0;">
                @for($i=1; $i<=5; $i++)
                    {{ $i <= $review->rating ? '★' : '☆' }}
                @endfor
            </p>
            <p style="font-style: italic;">"{{ $review->comment }}"</p>
        </div>

        <p>Partisipasi Anda sangat membantu pembeli lain.</p>
        <br>
        <p>Salam Hangat,<br>Tim KPMP Market</p>
    </div>
</body>
</html>