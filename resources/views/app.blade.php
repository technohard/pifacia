<!doctype html>
<html lang="en">
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="../api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css">
    <link rel="stylesheet" href="{{ asset('assets/css/libs.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.bundle.css') }}">
    <title>Pifacia Test</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
    <script src="{{ mix('css/app.css') }}"></script>
  </head>
  <body>
    <div id="app"></div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> --}}
    <script src='../api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <script src="{{ asset('assets/js/vendor.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/theme.bundle.js') }}"></script>
	<script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
