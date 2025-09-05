<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="{{ asset('resources/index.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
    </style>
</head>
<body>
<h1>Input Excel file</h1>
<h2>Here is the <a href="{{ asset('resources/template.csv') }}">Template</a></h2>

<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="input-file-container">
        <input name="file" class="input-file" id="my-file" type="file">
        <label tabindex="0" for="my-file" class="input-file-trigger">Select a file...</label>
    </div>
    <p class="file-return"></p>

    <button type="submit" id="submit-button">Submit</button>
    @if(Session::has('status'))
        <li class="session-section" style="background-color: #28a745; color: white">{{Session::get('status')}}</li>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <li class="session-section">{{ $error }}</li>
        @endforeach
    @endif

</form>



<script type="text/javascript" src="{{ asset('resources/index.js') }}"></script>
</body>
</html>
