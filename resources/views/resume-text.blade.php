<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Development Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .card-body {
            padding: 30px;
            font-size: 1.1rem;
            line-height: 1.7;
            color: #333;
            background-color: #ffffff;
        }
        .resume-text {
            white-space: pre-wrap;
            color: #444;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 500;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #0056b3;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
        }
        /* Gemini Cleanup Styles */
        .gemini-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            Your Generated Personal Development Plan
        </div>
        <div class="card-body">
            <!-- Display the Overview or Main Plan Text -->
            <div class="section-title">Overview</div>
            <div class="resume-text">
                {{ $resumeText }}  <!-- Dynamically loaded text from the AI -->
            </div>
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Your Company. All rights reserved.
    </div>
</div>

</body>
</html>
