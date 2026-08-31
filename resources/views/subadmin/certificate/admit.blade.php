<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $student->name }} - {{ $course->course_name }} - Certificate</title>
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
            background-color: #ffffff;
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

        .candidatePic {
            position: absolute;
            top: 23%;
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
            margin-bottom: 18pt;
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

        .certificateInfoItem .label:not(:first-child) {
            margin-left: 10px;
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
            background-image: url("{{ asset('images/border.png') }}");
            /* background-size: 100% 100%; */
            background-repeat: repeat-x;
            background-position: bottom;
        }

        .issueDate {
            /* Removed absolute positioning so it flows in flexbox */
        }

        .issueDate p {
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
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

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <div class="certWrapper">

        <div class="certInner">

            <div class="centeralWatermark">
                <img src="{{asset('images/7.png')}}" alt="">
            </div>

            <div class="topImage" style="margin-bottom: 5px;">
                <img src="{{asset('images/top-image-admit.png')}}" alt="">
            </div>

            <div class="candidatePic" style="position: absolute; top: 38%; right: 40px; z-index: 10;">
                <div class="userPhoto" style="width: 130px; border: 2px solid #ccc; padding: 2px; background: #fff;">
                    <img src="{{ asset($student->image) }}" alt="Student Photo" style="width: 100%; height: auto; display: block;">
                </div>
            </div>

            <div class="admitHeader" style="text-align: center; margin-top: 5px; margin-bottom: 10px;">
                <h1
                    style="color: #fe472f; font-weight: 800; font-size: 30px; letter-spacing: 2px; margin: 0; background-color: rgba(255,255,255,0.7); display: inline-block; padding: 5px 20px; border-radius: 5px;">
                    REGISTRATION CERTIFICATE</h1>
            </div>

            <div class="registrationHighlight"
                style="text-align: center; margin-bottom: 10px; background: #fff3f3; padding: 10px; border-radius: 8px; border: 2px dashed #fe472f;">
                <h2 style="margin: 0; color: #fe472f; font-weight: 800; font-size: 26px; letter-spacing: 1px;">
                    Registration No: {{ $student->registration_no }}</h2>
                <div style="margin-top: 10px; font-size: 18px; font-weight: 600; color: #333;">
                    <span>Registration Year: <span style="color: #000;">{{ $student->registration_year }}</span></span>
                    <span style="margin: 0 20px;">|</span>
                    <span>Enrollment No: <span style="color: #000;">{{ $student->enrollment_no }}</span></span>
                </div>
            </div>

            <div class="admitContent"
                style="display: flex; justify-content: space-between; padding: 0 40px; position: relative; z-index: 2; align-items: flex-start; margin-top: 10px;">
                <div class="admitDetails" style="flex: 1; padding-right: 20px;">
                    <table style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
                        <tr>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">Candidate Name</td>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">:</td>
                            <td style="font-size: 20px; color: #000; font-weight: 700; text-transform: uppercase;">
                                {{ $student->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">Father's Name</td>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">:</td>
                            <td style="font-size: 20px; color: #000; font-weight: 700; text-transform: uppercase;">
                                {{ $student->father_name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">Course Name</td>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">:</td>
                            <td style="font-size: 20px; color: #000; font-weight: 700; text-transform: uppercase;">
                                {{ $course->course_name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">Duration</td>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">:</td>
                            <td style="font-size: 20px; color: #000; font-weight: 700; text-transform: uppercase;">
                                {{ $course->duration }} {{ ucfirst($course->duration_type ?? 'months') }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">Study Center</td>
                            <td style="font-weight: bold; font-size: 20px; vertical-align: top;">:</td>
                            <td style="font-size: 20px; color: #000; font-weight: 700; text-transform: uppercase;">
                                {{ $student->org_name }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: flex-end; padding: 0 40px; margin-top: 30px; margin-bottom: 20px;">
                <div class="issueDate">
                    <p style="font-size: 18px; font-weight: bold; margin: 0;">Date : <span
                            style="color: #000; margin-left: 5px;">{{ \Carbon\Carbon::parse($issueDate)->format('d-m-Y') }}</span>
                    </p>
                </div>

                <div class="directorSignatureBlock" style="text-align: center; position: relative;">
                    <img src="{{asset('images/5.png')}}" alt="Stamp"
                        style="position: absolute; bottom: 35px; left: 50%; transform: translateX(-50%); width: 100px; z-index: 1; opacity: 0.8;">
                    <img src="{{asset('images/signature.png')}}" alt="Signature"
                        style="position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); width: 140px; z-index: 10;">
                    <div
                        style="border-top: 2px solid #ccc; color: #000; font-size: 18px; font-weight: 600; padding-top: 5px; width: 200px; position: relative; z-index: 20;">
                        Director Signature</div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- print button -->
    @auth('admin')
        <button class="print-button" onclick="printCertificate()">Print Certificate</button>
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