<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card - NITE</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .id-card {
            background: #fff;
            width: 360px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 6px;
            overflow: hidden;
            padding: 50px;
        }

        .header {
            background-color: #fff;
        }

        .header-logo {
            width: 100%;
            height: auto;
        }

        .profile-section {
            padding: 10px 0;
        }

        .photo-box {
            border: 2px solid #000;
            width: 150px;
            height: 180px;
            margin: 0 auto;
            overflow: hidden;
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .name {
            font-size: 1.6em;
            font-weight: bold;
            margin: 10px 0 5px;
        }

        .course {
            font-size: 0.9em;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .details {
            text-align: left;
            padding: 0 30px 10px;
        }

        .details h3 {
            text-align: center;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .details p {
            font-size: 0.9em;
            margin: 5px 0;
            line-height: 1.4;
        }

        .footer {
            /* border-top: 1px solid #ccc; */
            /* padding: 10px 15px; */
            font-size: 0.8em;
            color: #333;
        }

        .footer a {
            color: #0077cc;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-info {
            margin-top: 5px;
            line-height: 1.4;
        }


        /* Print button styling */
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        .print-btn:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="id-card" id="idCard">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('./assets/img/idtop.png') }}" alt="NITE Logo" class="header-logo">
        </div>

        <!-- Profile Section -->
        <div class="profile-section">
            <div class="photo-box">
                <img src="{{ asset($student->image) }}" alt="Profile Photo" class="profile-photo">
            </div>
            <h2 class="name" style="text-transform: capitalize;">{{$student->name}}</h2>
            <p class="course" style="text-transform: uppercase;">{{ $course->course_name }}</p>
        </div>

        <!-- Details -->
        <div class="details">
            <p style="text-align: center; text-transform: uppercase;">{{ $student->org_name }}</p>

            <div>
                <div style="display: grid; grid-template-columns: 4fr 8fr; gap:5px; justify-content: space-between; align-items: center;">
                    <p>Father's Name</p>
                    <p>: {{ $student->father_name }}</p>
                </div>

                <div style="display: grid; grid-template-columns: 4fr 8fr; gap:5px; justify-content: space-between; align-items: center;">
                    <p>Date Of Birth</p>
                    <p>: {{ $student->dob }}</p>
                </div>

                <div style="display: grid; grid-template-columns: 4fr 8fr; gap:5px; justify-content: space-between; align-items: center;">
                    <p>Mobile No</p>
                    <p>: {{ $student->phone }}</p>
                </div>

                <div style="display: grid; grid-template-columns: 4fr 8fr; gap:5px; justify-content: space-between; align-items: center;">
                    <p>Admission Date</p>
                    <p>: {{ $student->admission_date }}</p>
                </div>

                <div style="display: grid; grid-template-columns: 4fr 8fr; gap:5px; justify-content: space-between; align-items: center;">
                    <p>Enrollment No.</p>
                    <p>: {{ $student->enrollment_no }}</p>
                </div>
            </div>
        </div>

        <p><a href="https://www.niote.in" style="text-decoration: none; color: black;">www.niote.in</a></p>
        <hr>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-info">
                <strong>"NITE"</strong> House no. 113, Sankar Azan Path, Hatigaon, Bhetapara Road, Near Hatigaon police station,
                P.O.- Hatigaon, Guwahati, Assam, 781038<br>
                WARD NO-13, MUZAFFARPUR, BIHAR<br>
                Ph: 9835050556 | E-mail:
            </div>
        </div>
    </div>



    <!-- Print Button -->
    <button class="print-btn" id="downloadBtn">⬇️ Download ID Card</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.getElementById("downloadBtn").addEventListener("click", function() {
            const {
                jsPDF
            } = window.jspdf;
            const idCard = document.querySelector(".id-card");

            html2canvas(idCard, {
                scale: 2,
                useCORS: true, // fixes image not loading issue
                logging: false
            }).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF("p", "pt", [canvas.width, canvas.height]);
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = (canvas.height * pageWidth) / canvas.width;

                pdf.addImage(imgData, "PNG", 0, 0, pageWidth, pageHeight);
                pdf.save("ID_Card_{{ $student->name ?? 'student' }}.pdf");
            }).catch(err => {
                console.error("Error generating PDF:", err);
                alert("❌ Something went wrong while generating the PDF.");
            });
        });
    </script>
</body>

</html>