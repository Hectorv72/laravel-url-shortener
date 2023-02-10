<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shorty</title>
</head>
<body>
    <h1>¡Gracias por usar shorty! :)</h1>
    <h5>Redirigiendo a: {{ $urldir }}</h5>
    <script>
        setTimeout(() => {
            document.location.replace("{{ $urldir }}")
        }, 1000);
    </script>
</body>
</html>
