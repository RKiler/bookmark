<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="static/css/normalize.css">
    <link rel="stylesheet" href="static/css/milligram.min.css">

    <title>Document</title>
</head>
<body>
<div class="container">
    <p id="date">
        <?php
        date_default_timezone_set('Asia/Tokyo');
        echo date('l jS \of F Y h:i:s A');
        ?>
    </p>
</div>
</body>
</html>
