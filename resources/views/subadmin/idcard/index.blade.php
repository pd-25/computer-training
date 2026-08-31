<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card - NITE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playball&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .id-card {
            background-color: #fff;
            background-image: url("{{asset('images/4.png')}}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 360px;
            border: 4px solid #fe472f;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            /* border-radius: 10px; */
            overflow: hidden;
            padding-bottom: 20px;
            position: relative;
        }

        .centeralWatermark {
            position: absolute;
            opacity: 0.15;
            inset: 0;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 1;
        }

        .centeralWatermark img {
            width: 80%;
        }

        .header {
            background-color: #fff;
            position: relative;
            z-index: 2;
            border-bottom: 3px solid #fe472f;
        }

        .header-logo {
            width: 100%;
            height: auto;
            display: block;
        }

        .profile-section {
            padding: 20px 0 10px;
            position: relative;
            z-index: 2;
        }

        .photo-box {
            border: 3px solid #fe472f;
            width: 110px;
            height: 130px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .name {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.4em;
            font-weight: 800;
            color: #000;
            margin: 12px 0 4px;
            text-transform: uppercase;
        }

        .course {
            font-family: 'Playball', cursive;
            font-size: 1.2em;
            color: #fe472f;
            margin-bottom: 15px;
            margin-top: 0;
            text-transform: capitalize;
        }

        .details {
            text-align: left;
            padding: 0 25px 10px;
            position: relative;
            z-index: 2;
        }

        .org-name {
            text-align: center;
            font-size: 0.85em;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
            text-transform: uppercase;
            border: 2px solid #fe472f;
            padding: 5px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.8);
        }

        .info-row {
            display: flex;
            align-items: flex-end;
            margin-bottom: 12px;
        }

        .info-row .label {
            font-family: 'Playball', cursive;
            font-size: 16px;
            font-weight: 700;
            color: #000;
            width: 115px;
            flex-shrink: 0;
            letter-spacing: 0.5px;
        }

        .info-row .value {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #000;
            flex-grow: 1;
            border-bottom: 2px dotted #000;
            padding-bottom: 2px;
            margin-left: 5px;
        }

        .footer {
            position: relative;
            z-index: 2;
            font-size: 0.75em;
            color: #333;
            margin-top: 15px;
            padding: 0 20px;
        }

        .footer a {
            color: #fe472f;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.1em;
            display: inline-block;
            margin-bottom: 8px;
        }

        .footer-info {
            line-height: 1.4;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.7);
            padding: 5px;
            border-radius: 4px;
        }

        /* Print button styling */
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #fe472f;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
            font-family: 'Montserrat', sans-serif;
        }

        .print-btn:hover {
            background: #d93d28;
        }
    </style>
</head>

<body>
    <div class="id-card" id="idCard">
        
        <div class="centeralWatermark">
            <img src="{{asset('images/7.png')}}" alt="">
        </div>

        <!-- Header -->
        <div class="header">
            <img src="{{ asset('./assets/img/idtop.png') }}" alt="NITE Logo" class="header-logo">
        </div>

        <!-- Profile Section -->
        <div class="profile-section">
            <div class="photo-box">
                <img src="{{ asset($student->image) }}" alt="Profile Photo" class="profile-photo">
            </div>
            <h2 class="name">{{$student->name}}</h2>
            <p class="course">{{ $course->course_name }}</p>
        </div>

        <!-- Details -->
        <div class="details">
            <div class="org-name">{{ $student->org_name }}</div>

            <div class="info-row">
                <span class="label">Father's Name</span>
                <span class="value">{{ $student->father_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Date Of Birth</span>
                <span class="value">{{ $student->dob }}</span>
            </div>
            <div class="info-row">
                <span class="label">Mobile No</span>
                <span class="value">{{ $student->phone }}</span>
            </div>
            <div class="info-row">
                <span class="label">Admission Date</span>
                <span class="value">{{ $student->admission_date }}</span>
            </div>
            <div class="info-row">
                <span class="label">Enrollment No.</span>
                <span class="value">{{ $student->enrollment_no }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <a href="https://www.niote.in" target="_blank">www.niote.in</a>
            <div class="footer-info">
                <strong>"NITE"</strong> House no. 113, Sankar Azan Path, Hatigaon, Bhetapara Road, Near Hatigaon police station,
                P.O.- Hatigaon, Guwahati, Assam, 781038
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <button class="print-btn" id="downloadBtn">⬇️ Download ID Card</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.getElementById("downloadBtn").addEventListener("click", function() {

            const idCard = document.querySelector(".id-card");

            html2canvas(idCard, {
                scale: 2,
                useCORS: true,
                logging: false
            }).then(canvas => {

                // PNG Data
                const imgData = canvas.toDataURL("image/png");

                // Create download link
                const link = document.createElement("a");
                link.href = imgData;
                link.download = "ID_Card_{{ $student->name ?? 'student' }}.png";
                link.click();

            }).catch(err => {
                console.error("Error generating PNG:", err);
                alert("❌ Something went wrong while generating the PNG.");
            });

        });
    </script>
</body>

</html>