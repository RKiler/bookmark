<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/normalize.css">
    <link rel="stylesheet" href="static/css/milligram.min.css">

    <title>My Bookmarks</title>
</head>
<body>
<?php
$db = new PDO('mysql:host=db;dbname=default;charset=utf8', 'default', 'secret');
$db->query("insert into bookmark VALUES (NULL , 'google', 'https://google.com')");
$bookmarks = $db->query('SELECT * from bookmark');
$db = null
?>
<div class="container">
    <table>
        <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>url</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($bookmarks as $row): array_map('htmlentities', $row); ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['url']; ?><a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
