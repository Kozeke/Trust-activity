<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="viewport" content="width=1440">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
 

    <link href="https://fonts.googleapis.com/css?family=Itim" rel="stylesheet">
    <script src="/js/panel.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="/css/jumpout.min.css">
    <script type="text/javascript" src="/js/redactor.js"></script>
</head>
<body>
    <div id="redactor">
        <redactor></redactor>
        @if(isset($module_id))
            <input type="hidden" name="module_id" id="module_id" value="{{ $module_id }}" />
        @endif
    </div>
    <script src="/js/app.js" type="text/javascript"></script>
</body>
</html>