<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliation Certificate</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .certificate-container {
            width: 1000px;
            height: 700px;
            background-color: #fff;
            position: relative;
            padding: 40px;
            border: 10px solid #182b45;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            /* Background image combination: BG + Repeated Text */
            background-image: url('{{ asset("assets/img/certificate-bg.png") }}');
            background-size: cover;
            box-sizing: border-box;
            overflow: hidden;
        }

        .corner {
            position: absolute;
            width: 100px;
            height: 100px;
            border-style: solid;
            border-color: #d4af37;
        }
        .top-left { top: 20px; left: 20px; border-width: 5px 0 0 5px; }
        .top-right { top: 20px; right: 20px; border-width: 5px 5px 0 0; }
        .bottom-left { bottom: 20px; left: 20px; border-width: 0 0 5px 5px; }
        .bottom-right { bottom: 20px; right: 20px; border-width: 0 5px 5px 0; }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 120px;
            margin-bottom: 15px;
        }
        .title {
            font-size: 48px;
            color: #182b45;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 5px;
            margin: 0;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            padding-bottom: 10px;
        }
        .subtitle {
            font-size: 24px;
            color: #666;
            margin-top: 10px;
        }
        
        .content {
            text-align: center;
            margin: 30px 0;
        }
        .text-regular {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
        }
        .recipient-name {
            font-size: 36px;
            color: #d4af37;
            font-weight: bold;
            margin: 20px 0;
            font-style: italic;
            border-bottom: 1px solid #ccc;
            display: inline-block;
            min-width: 400px;
        }
        .org-name {
            font-size: 28px;
            color: #182b45;
            font-weight: bold;
            margin: 10px 0;
        }

        .footer {
            position: absolute;
            bottom: 60px;
            width: calc(100% - 80px);
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-group {
            text-align: center;
        }
        .signature-line {
            width: 200px;
            height: 1px;
            background-color: #333;
            margin-bottom: 5px;
        }
        .signature-text {
            font-size: 16px;
            font-weight: bold;
            color: #182b45;
        }
        .date-section {
            text-align: center;
            font-size: 16px;
        }
        
            .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px; /* Adjust size as needed */
            opacity: 0.1;
            z-index: 0;
            pointer-events: none;
        }

        @media print {
            body { 
                background: none; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
            .certificate-container {
                box-shadow: none;
                width: 100%;
                height: 100vh;
                border: 5px solid #182b45;
            }
        }
    </style>
</head>
<body>

    <div class="certificate-container">
        <!-- Corners -->
        <div class="corner top-left"></div>
        <div class="corner top-right"></div>
        <div class="corner bottom-left"></div>
        <div class="corner bottom-right"></div>


        <!-- Watermark -->
        <img src="{{ asset('logo.png') }}" class="watermark" alt="Watermark">

        <div class="header">
            <!-- Replace with your actual logo path -->
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
            <h2 class="subtitle" style="color: #182b45; font-weight: bold; margin-top: 0; margin-bottom: 5px;">NATIONAL INSTITUTE OF TECHNICAL EDUCATION</h2>
            <h1 class="title">Certificate of Affiliation</h1>
        </div>

        <div class="content">
            <p class="text-regular">This is to certify that</p>
            
            <div class="recipient-name">{{ $subadmin->name }}</div>
            
            <p class="text-regular">Director of</p>
            
            <div class="org-name">{{ $subadmin->org_name }}</div>
            
            <p class="text-regular">
                Has been officially granted affiliation as a customized training partner/franchise.
                <br>
                He/She is authorized to conduct training programs as per the guidelines of our organization.
            </p>
            
            <p class="text-regular" style="margin-top: 30px;">
                <strong>Franchise ID:</strong> {{ $subadmin->subadmin_unique_id }} <br>
                <strong>Email:</strong> {{ $subadmin->email }}
            </p>
        </div>

        <div class="footer">
            <div class="signature-group">
                <div class="date-section">
                    Date: {{ date('d-m-Y') }}
                </div>
            </div>

            <div class="signature-group">
                <!-- You can add a signature image here -->
                <!-- <img src="{{ asset('signature.png') }}" alt="Signature" style="max-height: 50px;"> -->
                <div class="signature-line"></div>
                <div class="signature-text">Authorized Signature</div>
                <div style="font-size: 12px;">{{ env('APP_NAME') }}</div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
