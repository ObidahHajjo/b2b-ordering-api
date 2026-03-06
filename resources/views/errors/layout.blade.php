<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Error')</title>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; background: #f8f8f8; color: #333; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; }
    </style>
</head>
<body>
<div class="container">
    @yield('content')
</div>
</body>
</html>
