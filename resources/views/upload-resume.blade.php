<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Upload Your Resume (PDF) and Choose AI for PDP</h2>
    <form action="{{ route('resume.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="resume" class="form-label">Resume (PDF)</label>
            <input type="file" class="form-control" id="resume" name="resume" accept="application/pdf" required>
        </div>

        <div class="mb-3">
            <label for="ai-choice" class="form-label">Choose AI for Personal Development Plan</label>
            <div>
                <input type="radio" id="textcortex" name="ai_choice" value="textcortex" checked>
                <label for="textcortex">TextCortex</label>
            </div>
            <div>
                <input type="radio" id="gemini" name="ai_choice" value="gemini">
                <label for="gemini">Gemini</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Generate PDP</button>
    </form>
</div>
</body>
</html>
