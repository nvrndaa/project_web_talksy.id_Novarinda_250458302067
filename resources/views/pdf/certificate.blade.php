<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Certificate - {{ $certificate->user->name }}</title>
    <style>
        /* SETUP HALAMAN A4 LANDSCAPE */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FCFBF9;
            /* Warm White Surface */
            color: #1E293B;
            /* Slate 800 */
            -webkit-print-color-adjust: exact;
        }

        /* CONTAINER UTAMA */
        .page-container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            overflow: hidden;
        }

        /* BACKGROUND PATTERN (Geometris Islamic Halus) */
        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            background-image: radial-gradient(#065F46 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: -1;
        }

        /* BORDER DEKORATIF */
        .border-outer {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 2px solid #065F46;
            /* Emerald */
            z-index: 1;
        }

        .border-inner {
            position: absolute;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;
            border: 1px solid #D4AF37;
            /* Gold */
            z-index: 1;
        }

        /* SUDUT ORNAMEN (Corner Accents) */
        .corner {
            position: absolute;
            width: 80px;
            height: 80px;
            border-style: solid;
            border-color: #065F46;
            z-index: 2;
        }

        .top-left {
            top: 15px;
            left: 15px;
            border-width: 8px 0 0 8px;
        }

        .top-right {
            top: 15px;
            right: 15px;
            border-width: 8px 8px 0 0;
        }

        .bottom-left {
            bottom: 15px;
            left: 15px;
            border-width: 0 0 8px 8px;
        }

        .bottom-right {
            bottom: 15px;
            right: 15px;
            border-width: 0 8px 8px 0;
        }

        /* KONTEN TENGAH */
        .content-wrapper {
            position: relative;
            z-index: 10;
            text-align: center;
            padding-top: 60px;
        }

        /* HEADER / LOGO */
        .logo {
            font-size: 28px;
            font-weight: 800;
            color: #065F46;
            letter-spacing: -0.5px;
            margin-bottom: 40px;
        }

        .logo span {
            color: #D4AF37;
        }

        /* JUDUL SERTIFIKAT */
        .cert-title {
            font-size: 52px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #065F46;
            margin: 0;
            line-height: 1;
        }

        .cert-subtitle {
            font-size: 16px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #D4AF37;
            margin-top: 10px;
            font-weight: 600;
        }

        /* BAGIAN UTAMA (NAMA & KURSUS) */
        .presented-to {
            font-size: 14px;
            color: #64748B;
            margin-top: 40px;
            font-style: italic;
        }

        .student-name {
            font-size: 64px;
            font-family: 'Times New Roman', serif;
            /* Font Serif terlihat lebih resmi untuk nama */
            color: #1E293B;
            margin: 15px 0;
            font-weight: bold;
            text-transform: capitalize;
            border-bottom: 1px solid #e2e8f0;
            display: inline-block;
            padding: 0 40px 10px 40px;
        }

        .completion-text {
            font-size: 16px;
            color: #475569;
            margin-top: 10px;
            line-height: 1.6;
        }

        .course-name {
            font-size: 32px;
            font-weight: 700;
            color: #065F46;
            margin-top: 5px;
        }

        /* FOOTER: TANDA TANGAN & INFO */
        .footer-table {
            width: 80%;
            margin: 60px auto 0 auto;
            border-collapse: collapse;
        }

        .footer-table td {
            text-align: center;
            vertical-align: top;
            width: 33%;
        }

        .sign-line {
            width: 80%;
            border-bottom: 1px solid #94a3b8;
            margin: 0 auto 10px auto;
            height: 40px;
            /* Space for signature image */
        }

        .sign-name {
            font-weight: bold;
            color: #1E293B;
            font-size: 14px;
        }

        .sign-title {
            font-size: 12px;
            color: #64748B;
        }

        /* SEAL / STEMPEL (Opsional) */
        .seal-container {
            width: 50px;
            height: 50px;
            margin: 0 auto;
            border: 2px dashed #D4AF37;
            border-radius: 50%;
            display: flex;
            /* Warning: Flex might not center perfectly in all PDF readers, purely decorative */
            align-items: center;
            justify-content: center;
            opacity: 0.8;
        }

        .seal-text {
            font-size: 10px;
            color: #D4AF37;
            font-weight: bold;
            line-height: 100px;
            /* Vertical center trick for PDF */
        }

        /* BOTTOM BAR */
        .bottom-bar {
            position: absolute;
            bottom: 35px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            letter-spacing: 1px;
        }

        /* Font Load Helper */
        @font-face {
            font-family: 'Plus Jakarta Sans';
            src: url('{{ public_path(' fonts/PlusJakartaSans-Regular.ttf') }}') format('truetype');
            font-weight: normal;
        }

        @font-face {
            font-family: 'Plus Jakarta Sans';
            src: url('{{ public_path(' fonts/PlusJakartaSans-Bold.ttf') }}') format('truetype');
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="page-container">
        <div class="bg-pattern"></div>
        <div class="border-outer"></div>
        <div class="border-inner"></div>

        <div class="corner top-left"></div>
        <div class="corner top-right"></div>
        <div class="corner bottom-left"></div>
        <div class="corner bottom-right"></div>

        <div class="content-wrapper">
            <div class="logo">Talksy<span>.id</span></div>

            <h1 class="cert-title">Certificate</h1>
            <div class="cert-subtitle">Of Proficiency</div>

            <p class="presented-to">This certificate is proudly presented to</p>

            <div class="student-name">
                {{ $certificate->user->name }}
            </div>

            <div class="completion-text">
                For successfully completing the comprehensive curriculum and <br>
                passing the final assessment for the course:
            </div>

            <div class="course-name">
                Talksy Englis For Moeslim
            </div>

            <table class="footer-table">
                <tr>
                    <td>
                        <div class="sign-line">
                        </div>
                        <div class="sign-name">Nova Rinda Dwi Cantika</div>
                        <div class="sign-title">Head of Curriculum</div>
                    </td>
                    {{-- <td>
                        <div class="seal-container">
                            <div class="seal-text">VERIFIED</div>
                        </div>
                    </td> --}}
                    <td>
                        <div class="sign-line">
                        </div>
                        <div class="sign-name">Talksy CEO</div>
                        <div class="sign-title">Chief Executive Officer</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="bottom-bar">
            CERTIFICATE ID: {{ $certificate->certificate_code }} &nbsp;|&nbsp;
            ISSUED DATE: {{ $certificate->created_at->format('d F Y') }} &nbsp;|&nbsp;
            VERIFY AT: talksy.id/verify
        </div>
    </div>

</body>

</html>