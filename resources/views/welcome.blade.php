<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{asset('front/1.0/css/app.min.css')}}" >
        <title>{{env('APP_NAME')}}</title>
    </head>
    <body>
        <script type="text/javascript" href="{{asset('front/1.0/js/bootstrap.min.js')}}" ></script>
    </body>
</html>