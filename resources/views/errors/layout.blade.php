<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('codigo') | {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/lab.css') }}" rel="stylesheet">
</head>
<body>
    <main class="error-pagina">
        <p class="error-codigo">@yield('codigo')</p>
        <h1>@yield('mensaje')</h1>
        <p class="error-detalle">@yield('detalle')</p>
        <a href="{{ url('/') }}" class="btn-pizarra">Volver al inicio</a>
    </main>
</body>
</html>