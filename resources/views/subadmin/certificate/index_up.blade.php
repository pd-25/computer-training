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
            background-image: url("{{ asset('images/4.png') }}");
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
            position: absolute;
            bottom: 5%;
            left: 2%;
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
    </style>
</head>

<body>
    <div class="certWrapper">

        <div class="certInner">

            <div class="centeralWatermark">
                <img src={{asset("images/7.png")}} alt="">
            </div>
            <div class="headerBarcodeInfo">
                <div class="barCodeImage">
                    <img src={{asset("images/barcode.png")}} alt="">
                </div>
                <div class="serialNumber">
                    <p>S.L NO. 890001</p>
                </div>
                <!-- <div class="digitalIndiaLogo">
                    <img src={/{asset()}}"images/2.png" alt="">
                </div> -->
            </div>
            <div class="topImage">
                <img src={{asset("images/top-image.png")}} alt="">
                <div class="candidatePic">
                    <div class="stamp">
                        <img src={{asset("images/5.png")}} alt="">
                    </div>
                    <div class="userPhoto">
                        <img src={{asset("images/6.jpg")}} alt="">
                    </div>
                </div>
            </div>
            <!-- <div>
                <div class="niotTextLogo">
                    <img src={/{asset()}}"images/1.png" alt="">
                </div>
                <div class="niotLogo">
                    <img src={/{asset()}}"images/7.png" alt="">
                </div>
                <div class="infoText">
                    <p>An Autonomous Institution Registered Under
                        AC EDUCATI
                        Indian Trust Act 1882 (Govt. of india) </p>
                    <p> Reg. No 2024/1GR039/4/13</p>
                    <p><span>Head office :-</span> Sankar Azan Path Hatigaon Bhrtapara Road
                        Near Hatigaon Police Station (Guwahati, Assam)</p>
                    <p>AN-ISO _9001:2015 Certified Organization</p>
                    <div class="msmeLogo">
                        <img src={/{asset()}}"images/3.png" alt="">
                    </div>
                    <div class="candidatePic">
                        <div class="stamp">
                            <img src={/{asset()}}"images/5.png" alt="">
                        </div>
                        <img src={/{asset()}}"images/6.jpg" alt="">
                    </div>
                </div>
                <div class="completeTextLogo">
                    <img src={/{asset()}}"images/8.png" alt="">
                </div>
            </div> -->

            <div class="certificateInfo">
                <div class="certificateInfoItem">
                    <span class="label">This is certify that Mr./Miss/Mrs.</span>
                    <span class="value" style="text-align: center;">SUJIT KUMAR</span>
                </div>
                <div class="certificateInfoItem">
                    <span class="label">Father Name</span>
                    <span class="value" style="text-align: center;">SUJIT KUMAR</span>
                </div>
                <div class="certificateInfoItem">
                    <span class="label">D.O.B</span>
                    <span class="value" style="text-align: center;">10/10/2000</span>
                </div>
                <div class="certificateInfoItem">
                    <span class="label">Registration No. is</span>
                    <span class="value" style="text-align: center;">1234567890</span>
                    <span class="label">Successfully Completed the</span>
                </div>
                <div class="certificateInfoItem">
                    <span class="label">Course</span>
                    <span class="value" style="text-align: center;">ADVANCE DIPLOMA IN COMPUTER APPLICATIONS
                        (ADCA)</span>
                </div>
                <div class="certificateInfoItem">
                    <span class="label">at Study Center</span>
                    <span class="value" style="text-align: center;">SUBHADRA INFOTECH, MUZAFFARPUR</span>
                </div>
                <div class="certificateInfoItem">
                    <span class="label">of Duration</span>
                    <span class="value" style="text-align: center;">1 Year</span>
                </div>
                <div class="certificateInfoItem">
                    <span class="label">and Obtained</span>
                    <span class="value" style="text-align: center;">84.2%</span>
                    <span class="label">Marks Grade</span>
                    <span class="value" style="text-align: center;">A</span>
                </div>
            </div>
            <div class="bottomImage">
                <img src={{asset("images/bottom-image.png")}} alt="">
            </div>
            <div class="issueDate">
                <p>Issue date: <span>10/10/2020</span></p>
            </div>
            <div class="controlExamination">
                <span>Signature</span>
                <p>Controller of Examination</p>
            </div>
            <div class="directorSignature">
                <span>
                    <img src={{asset("images/5.png")}} alt="">
                </span>
                <p>Director</p>
            </div>
        </div>
    </div>
</body>

</html>