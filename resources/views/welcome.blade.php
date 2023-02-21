<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Laravel</title>
    <style>
        code {
            color: #444;
            background-color: #eee;
            border: 1px solid #999;
            display: block;
            padding: 10px;
        }
    </style>
</head>

<body>
    <h4>Peticiones HTTP - API REST Shorty</h4>
    <div class="row gap-4 m-2 mt-4">
        <div>
            <p>Obtiene la información de todos los acortadores:</p>
            <div>
                <code>
                    <span class="badge bg-success me-2">GET: </span>
                    <a href="{{ route('api.shortener.all') }}" target="blank">
                        {{ route('api.shortener.all') }}
                    </a>
                </code>
            </div>
        </div>


        <div>
            <p>Crea un acortador:</p>
            <code>
                <span class="badge bg-danger me-2">POST:</span>
                <span>{{ route('api.shortener.create') }}</span>
            </code>
        </div>

        <div>
            <p>Obtiene información a cerca de un acortador específico:</p>
            <code>
                <span class="badge bg-success me-2">GET: </span>
                <a href="{{ route('api.shortener.find', ['key' => 'shortener-key']) }}" target="blank">
                    {{ route('api.shortener.find', ['key' => 'shortener-key']) }}
                </a>
            </code>
        </div>

        <div>
            <p>Crea un acortador:</p>
            <code>
                <span class="badge bg-danger me-2">POST:</span>
                <span>{{ route('api.auth.login') }}</span>
            </code>
        </div>
    </div>
</body>

</html>
