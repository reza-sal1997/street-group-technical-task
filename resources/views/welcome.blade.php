<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Homeowner CSV Upload</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .upload-container {
            max-width: 600px;
            margin-top: 5rem;
        }
    </style>
</head>
<body>
<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="container upload-container">
        <div class="card shadow-sm">
            <div class="card-body p-5">
                <h1 class="card-title text-center mb-4">Upload Homeowner CSV</h1>
                <p class="card-text text-center text-muted mb-4">
                    Please select a CSV file with a header row and a single column containing homeowner names. Here is the file <a href="{{ asset('resources/example.csv') }}">template</a>.
                </p>
                <div class="mb-3">
                    <label for="file" class="form-label">CSV File</label>
                    <input class="form-control" type="file" id="file" name="file" required accept=".csv">
                </div>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="session-section">{{ $error }}</li>
                    @endforeach
                @endif

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Upload and Parse</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
