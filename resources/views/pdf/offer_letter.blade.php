<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Offering Letter</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #0056b3; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #0056b3; }
        .content { font-size: 14px; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; }
        .details-table th, .details-table td { text-align: left; padding: 10px; border-bottom: 1px solid #ddd; }
        .details-table th { width: 30%; background-color: #f9f9f9; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 70px; border-top: 1px solid #000; width: 200px; display: inline-block; text-align: center; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKRUT MUDAH</h1>
        <p>Jl. Contoh Perusahaan No. 123, Jakarta Raya</p>
    </div>

    <div class="content">
        <p>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        
        <p>
            <strong>Kepada Yth.</strong><br>
            {{ $application->applicant->user->name }}<br>
            Di tempat
        </p>

        <p>Perihal: <strong>Penawaran Pekerjaan (Offering Letter)</strong></p>

        <p>Dengan hormat,</p>
        <p>Berdasarkan hasil seleksi wawancara dan penilaian yang telah dilakukan, kami dengan senang hati menawarkan Anda posisi di perusahaan kami dengan rincian sebagai berikut:</p>

        <table class="details-table">
            <tr>
                <th>Posisi Pekerjaan</th>
                <td>{{ $application->jobPosting->title }}</td>
            </tr>
            <tr>
                <th>Departemen</th>
                <td>{{ $application->jobPosting->department->name }}</td>
            </tr>
            <tr>
                <th>Gaji yang Ditawarkan</th>
                <td>Rp {{ number_format($salary_offered, 0, ',', '.') }} / bulan</td>
            </tr>
            <tr>
                <th>Tanggal Bergabung</th>
                <td>{{ \Carbon\Carbon::parse($join_date)->translatedFormat('d F Y') }}</td>
            </tr>
        </table>

        <p>Jika Anda setuju dengan penawaran ini, silakan memberikan konfirmasi melalui portal pelamar. Penawaran ini merupakan dokumen resmi yang sah.</p>
        
        <p>Kami sangat menantikan kehadiran Anda untuk bergabung dan berkembang bersama tim kami.</p>

        <div class="footer">
            <p>Hormat kami,</p>
            <div style="height: 50px;"></div>
            <div class="signature">Tim HR Rekrut Mudah</div>
        </div>
    </div>
</body>
</html>
