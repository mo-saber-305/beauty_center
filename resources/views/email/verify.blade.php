<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Beauty center</title>
    <style>
        body {
            text-align: center;
            font-family: Sans-serif;
        }

        .logo img {
            height: 50px;
        }
    </style>
</head>
<body>
<div>
    <?php
    $setting = \App\Models\Setting::first();
    ?>

    <div class="logo">
        <img src="{{ asset($setting->app_logo) }}" alt="logo">
    </div>

    <h2>Hi {{ $name }}</h2>

    <p>Thank you for creating an account with us. Don't forget to complete your registration!</p>

    <h4>your code is: {{ $verification_code }}</h4>
</div>
</body>
</html>

