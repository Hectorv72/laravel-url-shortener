<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Shorty</title>
    <style>
        .image {
            width: 90%;
        }
    </style>
</head>

<body>
    <div class="position-absolute top-50 start-50 translate-middle">
        <img src="{{ asset('images/shorty_splash.png') }}" class=" image" />
    </div>

    <script>
        setTimeout(() => {
            document.location.replace("{{ $urldir }}")
        }, 1000);
    </script>
</body>

</html>
