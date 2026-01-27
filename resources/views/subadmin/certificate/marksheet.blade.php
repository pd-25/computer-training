<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    <p><span> Sr.</span>890001 </p>
                    <p><span>Enroll. No.</span> 89000189</p>
                </div>
                <div class="rollNo">
                    <p>Roll No. <span>890001</span></p>
                </div>
            </div>
            <div class="topImage">
                <img src="{{asset("images/top-image.png")}}" alt="">
                <div class="candidatePic">
                    <div class="stamp">
                        <img src="{{asset("images/5.png")}}" alt="">
                    </div>
                    <div class="userPhoto">
                        <img src="{{asset("images/6.jpg")}}" alt="">
                    </div>
                </div>
            </div>
            <div class="studentInfo">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <span class="label">STUDENT NAME:</span>
                                <span class="value">SUJIT KUMAR</span>
                            </td>
                            <td>
                                <span class="label">DURATION</span>
                                <span class="value">3 MONTH</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label">FATHER NAME:</span>
                                <span class="value">SUJIT KUMAR</span>
                            </td>
                            <td>
                                <span class="label">SESSION:</span>
                                <span class="value"> 08-07-2023 TO 08-07-2024Z</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">DATE OF BIRTH:</span>
                                <span class="value"> 07-09-2000</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">COURSE NAME:</span>
                                <span class="value">CERTIFICATE IN COMPUTER BASED TYPING</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">STUDY CENTER: </span>
                                <span class="value">SUBHADRA INFOTECH, WARD NO-13, MUZAFFARPUR, BIHAR</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="designCopyright">
                <p>Design and Development By as Per Standards of National Institute of Technical Education</p>
            </div>
            <div class="marksTable">
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>LANGUAGE</th>
                            <th>SPEED w.p.m</th>
                            <th>accuracy</th>
                            <th>Grade</th>
                            <th>time taken</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hindi Typing</td>
                            <td>35 WPM</td>
                            <td>88%</td>
                            <td>A+</td>
                            <td>10:00 M</td>
                        </tr>
                        <tr>
                            <td>English Typing</td>
                            <td>38 WPM</td>
                            <td>90%</td>
                            <td>A+</td>
                            <td>10:00 M</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="issueDate">
                <p>Date of Issue: <span>10/10/2020</span></p>
            </div>
            <div class="bottoLogoHolder">
                <div class="qrCode">
                    <img src="{{asset("images/qr-pic.png")}}" alt="">
                </div>
                <div class="isoLogo">
                    <img src="{{asset("images/iso-logo.png")}}" alt="">
                </div>
            </div>

            <div class="controlExamination">
                <span>Signature</span>
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
</body>

</html>