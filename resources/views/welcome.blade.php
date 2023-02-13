<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <style>
        pre code {
            background-color: #eee;
            border: 1px solid #999;
            display: block;
            padding: 3px;
        }
    </style>
</head>

<body>
    <h4>Peticiones</h4>
    <pre>
        <code>
            {{ route('api.shortener.find', ['key' => 'shortener_key!']) }}
        </code>
    </pre>
    <pre>
        <code>
            {{ route('api.shortener.all') }}
        </code>
    </pre>
</body>

</html>
