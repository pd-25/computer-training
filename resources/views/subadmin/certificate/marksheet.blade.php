<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marksheet</title>
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
            padding: 40px;
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
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
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
            padding-bottom: 8px;
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
            padding-top: 20px;
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
            padding-top: 40px !important;
            padding-bottom: 40px !important;
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

        /* Marksheet Table Styles */
        .marks-table-container {
            margin: 30px 0;
            overflow-x: auto;
        }

        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .marks-table th {
            background: #1a237e;
            color: #fff;
            padding: 12px;
            text-align: left;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .marks-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            color: #333;
            font-size: 15px;
        }

        .marks-table tr:hover {
            background: #f9f9f9;
        }

        .marks-table tr:last-child td {
            border-bottom: none;
        }

        .total-row {
            background: #f5f5f5;
            font-weight: 600;
            border-top: 2px solid #1a237e;
        }

        .total-row td {
            color: #1a237e;
            font-size: 16px;
        }

        .grade-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 13px;
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

            .marks-table {
                font-size: 12px;
            }

            .marks-table th,
            .marks-table td {
                padding: 8px;
            }
        }

        /* ---------- PRINT OPTIMIZATION ---------- */
        @media print {
            body {
                padding: 0;
                zoom: 80%;
                /* Reduce overall size to fit 1 page */
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

            /* Reduce Ornament size */
            .ornament-top-left,
            .ornament-top-right,
            .ornament-bottom-left,
            .ornament-bottom-right {
                width: 45px !important;
                height: 45px !important;
                font-size: 14px !important;
            }

            /* Reduce text sizes */
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

            /* Table shrink */
            .marks-table th,
            .marks-table td {
                padding: 6px !important;
                font-size: 12px !important;
            }

            .grade-badge {
                font-size: 11px !important;
                padding: 2px 6px !important;
            }

            .total-row td {
                font-size: 14px !important;
            }

            .footer-details {
                font-size: 11px !important;
            }

            .website {
                font-size: 12px !important;
            }

            /* Remove extra page created by bottom margin */
            @page {
                margin: 10mm;
            }
        }

        /* floating Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <div class="certificate-border"></div>

        <div class="watermark"></div>

        <div class="ornament-top-left"></div>
        <div class="ornament-top-right"></div>
        <div class="ornament-bottom-left"></div>
        <div class="ornament-bottom-right"></div>

        <div class="header">
            <div class="organization-name">NATIONAL INSTITUTE OF TECHNICAL EDUCATION</div>
            <div class="organization-subtitle">An Autonomous Institution Registered Under Indian Trust Act 1882 (Govt.
                of India)</div>
            <div class="organization-subtitle">Reg. No: 2024/16R039/4/13</div>
            <div class="iso-badge">ISO 9001:2015 Certified Organization</div>
        </div>

        <div class="certificate-title">
            <h1>Marksheet</h1>
        </div>

        <div class="certificate-body">
            <div class="certificate-text">
                This is to certify that <strong style="text-transform: capitalize;">{{ $student->name }}</strong>
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

            <div class="certificate-text" style="font-size: 22px; color: #1a237e; font-weight: 500; margin: 20px 0;">
                {{ $course->course_name }}
            </div>

            <div class="student-details">
                <div class="detail-group">
                    <div class="detail-label">Study Center</div>
                    <div class="detail-value">{{ $student->org_name ?? 'N/A' }}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Duration</div>
                    <div class="detail-value">{{ $course->duration }}</div>
                </div>
            </div>

            <!-- Marks Table -->
            <div class="marks-table-container">
                <table class="marks-table">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th style="text-align: center;">Max Marks</th>
                            <th style="text-align: center;">Marks Obtained</th>
                            <th style="text-align: center;">Percentage</th>
                            <th style="text-align: center;">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjectDetails as $subject)
                        <tr>
                            <td>{{ $subject['name'] }}</td>
                            <td style="text-align: center;">{{ $subject['max_marks'] }}</td>
                            <td style="text-align: center;">{{ $subject['obtained_marks'] }}</td>
                            <td style="text-align: center;">{{ $subject['percentage'] }}%</td>
                            <td style="text-align: center;">
                                <span class="grade-badge grade-{{ strtolower(str_replace('+', '-plus', $subject['grade'])) }}">
                                    {{ $subject['grade'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td><strong>TOTAL</strong></td>
                            <td style="text-align: center;"><strong>{{ $totalMaxMarks }}</strong></td>
                            <td style="text-align: center;"><strong>{{ $totalMarksObtained }}</strong></td>
                            <td style="text-align: center;"><strong>{{ round($overallPercentage, 2) }}%</strong></td>
                            <td style="text-align: center;">
                                <span class="grade-badge grade-{{ strtolower(str_replace('+', '-plus', $overallGrade)) }}">
                                    {{ $overallGrade }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
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

                <div class="date-section">
                    <div class="detail-label">Issue Date</div>
                    <!-- <div class="issue-date">{{ date('d-m-Y') }}</div> -->
                    <div class="issue-date" id="todayDate"></div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="footer-logo"><img src="{{asset('./logo.png')}}" width="90" alt=""></div>
                <img src="{{asset('./iso9001.png')}}" width="120" alt="">
            </div>
            <div class="footer-details">
                Head office: Sankar Azan Path Hatiqaon Bhrtapara Road<br>
                Near Hatiqaon Police Station (Guwahati, Assam)
            </div>
            <div class="website">WEBSITE: WWW.NIOTE.IN | EMAIL: INFO@NIOTE.IN</div>
        </div>
    </div>
</body>


<div class="issue-date" id="todayDate"></div>

<!-- print button -->
<button class="print-button" onclick="printCertificate()">Print Marksheet</button>
<script>
    function printCertificate() {
        var printButton = document.querySelector('.print-button');
        printButton.style.display = 'none';
        window.print();
    }
</script>

<script>
    // Get today's date
    const today = new Date();

    // Format as dd-mm-yyyy
    const formattedDate = today.getDate().toString().padStart(2, '0') + '-' +
        (today.getMonth() + 1).toString().padStart(2, '0') + '-' +
        today.getFullYear();

    // Display in the div
    document.getElementById('todayDate').textContent = formattedDate;
</script>


</html>