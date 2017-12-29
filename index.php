<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<p id="date">
    <?php
    date_default_timezone_set('Asia/Tokyo');
    echo date('l jS \of F Y h:i:s A');
    ?>
</p>
</body>
</html>
