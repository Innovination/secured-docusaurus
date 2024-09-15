<!-- resources/views/projects/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $projectName }} Documentation</title>
    <link rel="stylesheet" href="{{ asset('static/' . $projectName . '/css/style.css') }}">
</head>
<body>
    <h1>Welcome to {{ $projectName }} Documentation</h1>
    <script src="{{ asset('static/' . $projectName . '/js/app.js') }}"></script>
</body>
</html>
