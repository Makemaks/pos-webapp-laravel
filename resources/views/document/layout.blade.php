<!DOCTYPE html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="uikit/css/uikit.css">
    <script src="uikit/js/uikit.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/color.css">
</head>

<style>
    table {
        font-size: 11px !important;
    }

    .search-form {
        display: none;
    }

    .button-pdf {
        display: none;
    }

</style>

<body>
    @yield('content')

</body>

</html>
