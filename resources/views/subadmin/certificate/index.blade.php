<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Completion</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .certificate { border: 10px solid #ccc; padding: 50px; }
        h1 { font-size: 50px; margin-bottom: 20px; }
        h2 { font-size: 30px; margin-bottom: 40px; }
        p { font-size: 20px; }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <h2>{{ $course->course_name }}</h2>
        <p>This is to certify that</p>
        <h2>{{ $student->name }}</h2>
        <h2>{{ $student->email }}</h2>
        <p>has successfully completed the course.</p>
        <p>Date: {{ date('d M, Y') }}</p>
    </div>
</body>
</html>
