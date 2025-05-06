<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Student Grades Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .student-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Student Grades Report</h1>
    </div>

    <div class="student-info">
        <p><strong>Student Name:</strong> {{ $student->name }}</p>
        <p><strong>Report Date:</strong> {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Unit</th>
                <th>CAT Marks</th>
                <th>Exam Marks</th>
                <th>Total Marks</th>
                <th>Grade</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
                @php
                    $totalMarks = ($grade->cat_marks ?? 0) + ($grade->exam_marks ?? 0);
                    $gradeLetter = '';
                    if ($totalMarks >= 70) {
                        $gradeLetter = 'A';
                    } elseif ($totalMarks >= 60) {
                        $gradeLetter = 'B';
                    } elseif ($totalMarks >= 50) {
                        $gradeLetter = 'C';
                    } elseif ($totalMarks >= 40) {
                        $gradeLetter = 'D';
                    } else {
                        $gradeLetter = 'F';
                    }
                @endphp
                <tr>
                    <td>{{ $grade->unit->title }}</td>
                    <td>{{ $grade->cat_marks ?? 'N/A' }}</td>
                    <td>{{ $grade->exam_marks ?? 'N/A' }}</td>
                    <td>{{ $totalMarks }}</td>
                    <td>{{ $gradeLetter }}</td>
                    <td>{{ \Carbon\Carbon::parse($grade->uploaded_at)->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generated on: {{ now()->format('F d, Y H:i:s') }}</p>
    </div>
</body>
</html> 