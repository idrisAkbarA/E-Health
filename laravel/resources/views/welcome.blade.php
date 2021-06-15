<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <meta name="description" content="Home">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <link rel="icon" href="{{ asset('/images/LogoUIN.png') }}"> --}}

</head>

<body>
    <div id="app-vue">
        <v-app id="inspire">
            <v-card>
                <v-card-title>Test</v-card-title>
            </v-card>
        </v-app>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
