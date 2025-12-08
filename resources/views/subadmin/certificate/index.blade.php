<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #f5f2e9 0%, #e8e1cf 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .certificate-container {
            position: relative;
            width: 100%;
            max-width: 900px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            overflow: hidden;
            padding: 30px;
            border: 12px solid transparent;
        }

        .watermark {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.08;
            background-repeat: repeat;
            background-size: 450px 50px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='450' height='50'%3E%3Ctext x='5' y='30' font-size='13' font-weight='600' fill='red'%3ENATIONAL INSTITUTE OF TECHNICAL EDUCATION%3C/text%3E%3C/svg%3E");
        }

        .certificate-border {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 2px solid #d4af37;
            border-radius: 8px;
            pointer-events: none;
        }

        .certificate-border::before,
        .certificate-border::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px solid #d4af37;
            border-radius: 8px;
            top: -8px;
            left: -8px;
        }

        .certificate-border::after {
            top: 8px;
            left: 8px;
        }

        .ornament-top-left,
        .ornament-top-right,
        .ornament-bottom-left,
        .ornament-bottom-right {
            position: absolute;
            width: 80px;
            height: 80px;
            background: #1a237e;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #d4af37;
            font-size: 24px;
            z-index: 2;
        }

        .ornament-top-left {
            top: -20px;
            left: -20px;
        }

        .ornament-top-right {
            top: -20px;
            right: -20px;
        }

        .ornament-bottom-left {
            bottom: -20px;
            left: -20px;
        }

        .ornament-bottom-right {
            bottom: -20px;
            right: -20px;
        }

        .ornament-top-left::before,
        .ornament-top-right::before,
        .ornament-bottom-left::before,
        .ornament-bottom-right::before {
            content: '✦';
            font-size: 24px;
            color: #d4af37;
        }

        .header {
            text-align: center;
            /* margin-bottom: 30px; */
            position: relative;
            padding-bottom: 10px;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20%;
            width: 60%;
            height: 2px;
            background: linear-gradient(to right, transparent, #d4af37, transparent);
        }

        .organization-name {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .organization-subtitle {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        .iso-badge {
            display: inline-block;
            background: #d4af37;
            color: #1a237e;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-top: 10px;
        }

        .certificate-title {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .certificate-title h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: #1a237e;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .certificate-title::before,
        .certificate-title::after {
            content: '✻';
            color: #d4af37;
            font-size: 24px;
            margin: 0 15px;
        }

        .certificate-body {
            margin: 40px 0;
        }

        .certificate-text {
            font-size: 18px;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .student-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .detail-group {
            flex: 1;
            min-width: 200px;
            margin: 10px;
        }

        .detail-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 500;
            color: #1a237e;
            padding-bottom: 5px;
            border-bottom: 1px dashed #ccc;
        }

        .performance-section {
            text-align: center;
            margin: 30px 0;
            font-style: italic;
            color: #555;
            font-size: 16px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .signature {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            width: 150px;
            height: 1px;
            background: #333;
            margin: 0 auto 5px;
        }

        .signature-name {
            font-weight: 500;
            color: #1a237e;
        }

        .signature-title {
            font-size: 14px;
            color: #666;
        }

        .date-section {
            text-align: right;
            margin-top: 30px;
        }

        .issue-date {
            font-weight: 500;
            color: #1a237e;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .footer-logo {
            display: inline-block;
            width: 120px;
            height: 60px;
            background: #E4DFDA;
            color: #d4af37;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
            padding-top: 30px !important;
            padding-bottom: 30px !important;
        }

        .footer-details {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }

        .website {
            color: #1a237e;
            font-weight: 500;
            margin-top: 10px;
        }

        .grade-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 22px;
            background: #d4af37;
            color: #1a237e;
            border: 2px solid #1a237e;
        }

        @media (max-width: 768px) {
            .certificate-container {
                padding: 20px;
            }

            .organization-name {
                font-size: 24px;
            }

            .certificate-title h1 {
                font-size: 28px;
            }

            .certificate-text {
                font-size: 16px;
            }

            .ornament-top-left,
            .ornament-top-right,
            .ornament-bottom-left,
            .ornament-bottom-right {
                width: 50px;
                height: 50px;
            }
        }

        @media print {
            body {
                padding: 0;
                zoom: 80%;
            }

            .certificate-container {
                padding: 20px !important;
                border-width: 6px !important;
            }

            .certificate-border {
                border-width: 1px !important;
            }

            .certificate-border::before,
            .certificate-border::after {
                border-width: 1px !important;
            }

            .ornament-top-left,
            .ornament-top-right,
            .ornament-bottom-left,
            .ornament-bottom-right {
                width: 45px !important;
                height: 45px !important;
                font-size: 14px !important;
            }

            .organization-name {
                font-size: 20px !important;
            }

            .organization-subtitle {
                font-size: 11px !important;
            }

            .certificate-title h1 {
                font-size: 26px !important;
            }

            .certificate-text {
                font-size: 14px !important;
            }

            .detail-value {
                font-size: 14px !important;
            }

            .footer-details {
                font-size: 11px !important;
            }

            .website {
                font-size: 12px !important;
            }

            .print-button {
                display: none !important;
            }

            @page {
                margin: 10mm;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: #1a237e;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .print-button:hover {
            background: #0d1642;
        }
    </style>
</head>

<body>
    <div class="certificate-container" style="position: relative; background: linear-gradient(
        rgba(255,255,255,0.9),
        rgba(255,255,255,0.9)
    ),url({{asset('logo.png')}}); background-repeat: no-repeat; background-position: center; background-size: contain; overflow: hidden;">
        <div class="watermark"></div>
        <div class="certificate-border"></div>

        <div class="ornament-top-left"></div>
        <div class="ornament-top-right"></div>
        <div class="ornament-bottom-left"></div>
        <div class="ornament-bottom-right"></div>

        <div class="header">
            <div class="organization-name">NATIONAL INSTITUTE OF TECHNICAL EDUCATION</div>
            <div class="organization-subtitle">An Autonomous Institution Registered Under Indian Trust Act 1882 (Govt. of India)</div>
            <div class="organization-subtitle">Reg. No: 2024/16R039/4/13</div>
            <div class="iso-badge">ISO 9001:2015 Certified Organization</div>
        </div>

        <div class="certificate-title">
            <h1>Certificate of Completion</h1>
        </div>

        <div class="certificate-body">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="certificate-text">
                    This is to certify that <strong style="text-transform: capitalize;">{{ $student->name }}</strong>
                </div>

                <img src="{{ asset($student->image) }}" alt="" width="120px" style=" border: 1px solid #1a237e; padding: 5px;">

            </div>

            <div class="student-details">
                <div class="detail-group">
                    <div class="detail-label">Father's Name</div>
                    <div class="detail-value" style="text-transform: uppercase;">{{ $student->father_name ?? 'N/A' }}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Date of Birth</div>
                    <div class="detail-value">{{ $student->dob ?? 'N/A' }}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Enrollment No.</div>
                    <div class="detail-value">{{ $student->enrollment_no ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="certificate-text">
                has successfully completed the course
            </div>

            <div class="certificate-text" style="font-size: 22px; color: #1a237e; font-weight: 500; margin: 20px 0; text-transform: capitalize;">
                {{ $course->course_name }}
            </div>

            <div class="student-details">
                <div class="detail-group">
                    <div class="detail-label">Study Center</div>
                    <div class="detail-value">{{ $student->org_name ?? 'N/A' }}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Duration</div>
                    <div class="detail-value">{{ $course->duration }} Months</div>
                </div>
            </div>

            <div class="student-details">
                <div class="detail-group">
                    <div class="detail-label">Total Marks</div>
                    <div class="detail-value">{{ $grandTotalObtained }} / {{ $grandTotalMax }}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Percentage</div>
                    <div class="detail-value">{{ $marksObtainedInPercent }}%</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Grade</div>
                    <div class="detail-value">
                        <span class="">{{ $grade }}</span>
                    </div>
                </div>
            </div>

            <div class="performance-section">
                During the course his/her performance was good and we wish him/her best of luck for future endeavors
            </div>

            <div class="signature-section">
                <div class="signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">Controller of Examination</div>
                    <div class="signature-title">National Institute of Technical Education</div>
                </div>

                <div class="signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">Center Director</div>
                    <div class="signature-title">{{ $student->org_name ?? 'N/A' }}</div>
                </div>

                <div class="date-section">
                    <div class="detail-label">Issue Date</div>
                    <div class="issue-date" id="todayDate"></div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="footer-logo"><img src="{{asset('./logo.png')}}" width="90" alt=""></div>

                <div style="text-align: center;">
                    @if(isset($qrCodeBase64))
                    <img src="data:image/png;base64,{{ $qrCodeBase64 }}"
                        alt="Certificate QR Code"
                        style="border: 2px solid #d4af37; padding: 5px; border-radius: 4px;">
                    <div style="font-size: 10px; color: #666; margin-top: 5px;">
                        Scan to Verify
                    </div>
                    @endif
                </div>

                <img src="{{asset('./iso9001.png')}}" width="120" alt="">
            </div>
            <div class="footer-details">
                Head office: House no. 113, Sankar Azan Path, Hatigaon, Bhetapara Road, <br> Near Hatigaon police station,Hatigaon, Guwahati, Assam, 781038
            </div>
            <div class="website">WEBSITE: WWW.NIOTE.IN | EMAIL: INFO@NIOTE.IN</div>
        </div>
    </div>

    <button class="print-button" onclick="printCertificate()">Print Certificate</button>

    <script>
        function printCertificate() {
            window.print();
        }

        // Set today's date
        const today = new Date();
        const formattedDate = today.getDate().toString().padStart(2, '0') + '-' +
            (today.getMonth() + 1).toString().padStart(2, '0') + '-' +
            today.getFullYear();
        document.getElementById('todayDate').textContent = formattedDate;
    </script>
</body>

</html>