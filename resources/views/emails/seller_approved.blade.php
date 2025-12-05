<!DOCTYPE html>
<html>
<head>
    <title>Toko Disetujui</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 40px; }
        .header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #4F46E5; margin: 0; font-size: 24px; }
        .content { color: #333; line-height: 1.6; }
        .status-badge { display: inline-block; background-color: #d1fae5; color: #065f46; padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 14px; margin: 10px 0; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; }
        .btn { display: inline-block; background-color: #4F46E5; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KPMP Marketplace</h1>
        </div>
        
        <div class="content">
            <p>Halo, <strong>{{ $seller->pic_name }}</strong>!</p>
            <p>Kami membawa kabar gembira. Pengajuan pembukaan toko Anda telah kami tinjau dan hasilnya:</p>
            
            <div style="text-align: center;">
                <span class="status-badge">DISETUJUI (APPROVED)</span>
            </div>

            <p>Selamat! Toko <strong>{{ $seller->store_name }}</strong> sekarang sudah aktif. Anda dapat segera login ke dashboard untuk mulai mengunggah produk dan berjualan.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/dashboard') }}" class="btn">Masuk ke Dashboard</a>
            </div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} KPMP Marketplace. All rights reserved.<br>
            Email ini dikirim secara otomatis, mohon tidak membalas.
        </div>
    </div>
</body>
</html>