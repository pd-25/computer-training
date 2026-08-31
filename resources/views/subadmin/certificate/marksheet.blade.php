<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $student->name }} - {{ $course->course_name }} - Marksheet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playball&family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            /* background-image: url(images/frame.png); */
        }

        .serialNumber {
            text-align: center;
            margin: 0;
        }

        .serialNumber p {
            margin: 0;
            margin-top: -20px;
        }

        @page {
            size: A4;
            margin: 0;

            padding-left: 20px;
            padding-right: 20px;
            padding-top: 10px;
            padding-bottom: 10px;

        }

        .certWrapper {
            position: relative;
        }


        .certInner {
            background-image: url("{{asset('images/4.png')}}");
            /* background-size: cover; */
            background-position: center;
            background-repeat: repeat;
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            border-radius: 10px;
            position: relative;
            border: 4px solid #fe472f;
        }

        .barCodeImage {
            position: absolute;
            left: 10px;
            top: 10px;
            max-width: 200px;
        }

        .barCodeImage img {
            width: 100%;
        }


        .centeralWatermark {
            position: absolute;
            opacity: .2;
            inset: 0;
            text-align: center;
            max-width: 900px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            pointer-events: none;
            top: 20%;
        }

        .centeralWatermark img {
            width: 100%;
        }

        .topImage,
        .bottomImage {
            text-align: center;
        }

        .marksheetWrapper .candidatePic {
            position: absolute;
            top: 29%;
            right: 2%;
        }

        .stamp {
            max-width: 80px;
            position: absolute;
            left: -40px;
            top: 30px;
        }

        .stamp img {
            width: 100%;
        }

        .userPhoto {
            max-width: 100px;
        }

        .userPhoto img {
            width: 100%;
        }

        .certificateInfoItem {
            display: flex;
            align-items: flex-end;
        }

        .certificateInfoItem {
            margin-bottom: 20pt;
        }

        .certificateInfoItem .label {
            font-family: 'Playball', cursive;
            font-size: 24px;
            font-weight: 700;
            color: #000000;
            height: 30px;
            display: flex;
            align-items: flex-end;
            line-height: 1;
            position: relative;
            top: 3px;
            letter-spacing: 1px;
        }

        .certificateInfoItem .value {
            height: 30px;
            flex-grow: 1;
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            font-weight: 600;
            color: #000000;
            margin-left: 10px;
            padding-bottom: 8px;
            /* border-bottom: 5px dashed #000000; */
            background-image: url("{{asset('images/border.png')}}");
            /* background-size: 100% 100%; */
            background-repeat: repeat-x;
            background-position: bottom;
        }

        .marksheetWrapper .issueDate {
            position: static;

        }

        .marksheetWrapper .issueDate p {
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
            display: flex;
            align-items: flex-end;
            gap: 12px;
        }

        .marksheetWrapper .issueDate span {
            border-bottom: 4px dotted #000000;
            padding: 5px 20px 0;
            margin: 0;
            margin-top: 5px;
            position: relative;
            top: -3px;
        }


        .controlExamination {
            position: absolute;
            bottom: 5%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        .controlExamination p,
        .directorSignature p {
            border-top: 4px dotted #000000;
            padding: 5px 20px 0;
            margin: 0;
            margin-top: 5px;
        }

        .controlExamination span {
            font-family: 'Playball', cursive;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .directorSignature {
            position: absolute;
            right: 5%;
            bottom: 5%;
            text-align: center;
        }

        .directorSignature img {
            max-width: 110px;
            position: relative;
            top: 33px;
        }

        .frame {
            position: absolute;
            inset: 0;
        }

        .frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .headerBarcodeInfo p {
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 5px;
        }

        .headerBarcodeInfo .srNo p span {
            min-width: 120px;
            display: inline-flex;
        }

        .marksheetWrapper .headerBarcodeInfo {
            display: flex;
            justify-content: space-between;
        }

        .studentInfo td {
            font-size: 18px;
            font-weight: 600;
            padding: 8px 0;
        }

        .studentInfo td .label {
            min-width: 200px;
            display: inline-flex;
        }

        .designCopyright p {
            font-family: 'Times New Roman', Times, serif;
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            padding: 5px;
            border: 4px solid #fe472f;
            border-radius: 4px;
        }

        .marksTable table {
            border: 2px solid #000000;
            border-spacing: 0;
        }

        .marksTable table th,
        .marksTable table td {
            font-size: 20px;
            padding: 8px;
            text-align: center;
            font-family: 'Playball', cursive;
            text-transform: uppercase;
            border-right: 2px solid #000000;
            border-bottom: 2px solid #000000;
        }

        .marksTable table th:last-child,
        .marksTable table td:last-child {
            border-right: 0;
        }

        .marksTable table td {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }

        .marksTable table tr:last-child td {
            border-bottom: 0;
        }

        .bottoLogoHolder {
            display: flex;
            gap: 40px;
            margin-top: 40px;
            margin-bottom: 50px;
        }

        .marksheetWrapper .bottomImage {
            padding: 10px 0 0;
            border-top: 3px solid #fe472f;
            margin: 0 -20px -15px;
        }

        .controlExamination p,
        .directorSignature p {
            font-weight: 600;
            font-family: 'Times New Roman', Times, serif;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <div class="certWrapper marksheetWrapper">

        <div class="certInner">

            <div class="centeralWatermark">
                <img src="{{asset("images/7.png")}}" alt="">
            </div>
            <div class="headerBarcodeInfo">
                <div class="srNo">
                    <p><span> Sr.</span>{{ $student->id }} </p>
                    <!-- <p><span>Enroll. No.</span> {{ $student->enrollment_no }}</p> -->
                </div>
                <div class="rollNo">
                    <p>Enroll. No. <span>{{ $student->enrollment_no }}</span></p>
                </div>
            </div>
            <div class="topImage">
                <img src="{{asset("images/top-image.png")}}" alt="">
                <div class="candidatePic">
                    <div class="stamp">
                        <img src="{{asset("images/5.png")}}" alt="">
                    </div>
                    <div class="userPhoto">
                        <img src="{{ asset($student->image) }}" alt="">
                    </div>
                </div>
            </div>
            <div class="studentInfo">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <span class="label">STUDENT NAME:</span>
                                <span class="value" style="text-transform: uppercase;">{{ $student->name }}</span>
                            </td>
                            <td>
                                <span class="label">DURATION:</span>
                                <span class="value">{{ $course->duration }} {{ strtoupper($course->duration_type ?? 'MONTHS') }}</span>
                                <br>
                                <span class="label">SESSION:</span>
                                <span class="value">{{ \Carbon\Carbon::parse($mark->session_from)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($mark->session_to)->format('d-m-Y') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label">FATHER NAME:</span>
                                <span class="value" style="text-transform: uppercase;">{{ $student->father_name }}</span>
                            </td>
                            <!-- <td>
                                <span class="label">SESSION:</span>
                                <span class="value"> {{ $student->session ?? 'N/A' }}</span>
                            </td> -->
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">DATE OF BIRTH:</span>
                                <span class="value"> {{ $student->dob }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">COURSE NAME:</span>
                                <span class="value" style="text-transform: uppercase;">{{ $course->course_name }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">STUDY CENTER: </span>
                                <span class="value" style="text-transform: uppercase;">{{ $student->org_name }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="designCopyright">
                <p>Design and Development By as Per Standards of National Institute of Technical Education</p>
            </div>
            <div class="marksTable">
                <!-- If SINGLE YEAR data exists -->
                @if(isset($subjectDetails))
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Max Marks</th>
                            <th>Obtained Marks</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjectDetails as $subject)
                        <tr>
                            <td>{{ $subject['name'] }}</td>
                            <td>{{ $subject['max_marks'] }}</td>
                            <td>{{ $subject['obtained_marks'] }}</td>
                            <td>{{ $subject['percentage'] }}%</td>
                            <td>{{ $subject['grade'] }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td><strong>TOTAL</strong></td>
                            <td><strong>{{ $totalMaxMarks }}</strong></td>
                            <td><strong>{{ $totalMarksObtained }}</strong></td>
                            <td><strong>{{ round($overallPercentage, 2) }}%</strong></td>
                            <td><strong>{{ $overallGrade }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                @elseif(isset($allYearsData))
                <!-- Multi Year Data -->
                @foreach($allYearsData as $year => $yearData)
                <h4 style="text-align:center; font-family: 'Playball', cursive; margin: 10px 0;">Year {{ $year }}</h4>
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Max Marks</th>
                            <th>Obtained Marks</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($yearData['subjects'] as $subject)
                        <tr>
                            <td>{{ $subject['name'] }}</td>
                            <td>{{ $subject['max_marks'] }}</td>
                            <td>{{ $subject['obtained_marks'] }}</td>
                            <td>{{ $subject['percentage'] }}%</td>
                            <td>{{ $subject['grade'] }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td><strong>Total (Year {{ $year }})</strong></td>
                            <td><strong>{{ $yearData['total_max'] }}</strong></td>
                            <td><strong>{{ $yearData['total_obtained'] }}</strong></td>
                            <td><strong>{{ round($yearData['percentage'], 2) }}%</strong></td>
                            <td><strong>{{ $yearData['grade'] }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
                
                <h4 style="text-align:center; font-family: 'Playball', cursive; margin: 10px 0;">Grand Total</h4>
                <table style="width: 100%;">
                     <tr>
                        <td><strong>Grand Total Marks</strong></td>
                        <td><strong>{{ $grandTotalMax }}</strong></td>
                        <td><strong>{{ $grandTotalObtained }}</strong></td>
                        <td><strong>{{ round($grandPercentage, 2) }}%</strong></td>
                        <td><strong>{{ $grandGrade }}</strong></td>
                    </tr>
                </table>
                @endif
            </div>
            <div class="issueDate">
                <p>Date of Issue: <span id="">{{ \Carbon\Carbon::parse($mark->issue_date)->format('d-m-Y') }}</span></p>
            </div>
            <div class="bottoLogoHolder">
                <div class="qrCode" style="text-align: center;">
                    <!-- @if(isset($qrCodeBase64))
                    <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code" style="border: 2px solid #d4af37; padding: 5px; border-radius: 4px; width: 100px; height: 100px;">
                    <div style="font-size: 10px; color: #666; margin-top: 5px; font-family: 'Montserrat', sans-serif; font-weight: 600;">Scan to Verify</div>
                    @else
                    <img src="{{asset("images/qr-pic.png")}}" alt="">
                    @endif -->
                </div>
                <div class="isoLogo">
                    <img src="{{asset("images/iso-logo.png")}}" alt="">
                </div>
            </div>

            <div class="controlExamination">
                <!-- <span>Signature</span> -->
                <p>Controller of Examination</p>
            </div>
            <div class="directorSignature">
                <span>
                    <img src="{{asset("images/5.png")}}" alt="">
                </span>
                <p>Director</p>
            </div>
            <div class="bottomImage">
                <img src="{{asset("images/bottom-info-pic.png")}}" alt="">
            </div>
        </div>
    </div>

    <!-- print button -->
    @auth('admin')
    <button class="print-button" onclick="printCertificate()">Print Marksheet</button>
    @endauth

    <script>
        function printCertificate() {
            var printButton = document.querySelector('.print-button');
            printButton.style.display = 'none';
            window.print();
        }
    </script>


     <script>
        // Set today's date
        const today = new Date();
        const formattedDate = today.getDate().toString().padStart(2, '0') + '-' +
            (today.getMonth() + 1).toString().padStart(2, '0') + '-' +
            today.getFullYear();
        document.getElementById('todayDate').textContent = formattedDate;
    </script>
</body>

</html>