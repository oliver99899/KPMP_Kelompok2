<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Ditolak</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 40px; }
        .header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #4F46E5; margin: 0; font-size: 24px; }
        .content { color: #333; line-height: 1.6; }
        .status-badge { display: inline-block; background-color: #fee2e2; color: #991b1b; padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 14px; margin: 10px 0; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KPMP Marketplace</h1>
        </div>
        
        <div class="content">
            <p>Halo, <strong>{{ $seller->pic_name }}</strong>.</p>
            <p>Terima kasih telah mendaftar sebagai mitra penjual. Setelah melalui proses verifikasi, dengan berat hati kami informasikan bahwa pengajuan toko Anda:</p>
            
            <div style="text-align: center;">
                <span class="status-badge">DITOLAK (REJECTED)</span>
            </div>

            <p>Mohon maaf, toko <strong>{{ $seller->store_name }}</strong> belum memenuhi kriteria kami saat ini. Silakan periksa kembali kelengkapan dokumen atau data diri Anda, dan lakukan pendaftaran ulang jika sudah diperbaiki.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} KPMP Marketplace. All rights reserved.<br>
            Email ini dikirim secara otomatis, mohon tidak membalas.
        </div>
    </div>
</body>
</html>