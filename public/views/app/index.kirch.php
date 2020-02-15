<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
    <title><?php echo $title ?> </title>
</head>
<body>
    <ul>
        <?php if($users){ foreach($users as $user) { ?>
            <li><?php echo $user['name'] ?></li>
        <?php } } else{
            echo 'No User';
        } ?>
        
        <?php 
            $db_host = env('DB_HOST');
            $db_database = env('DB_DATABASE');
            $db_username = env('DB_USERNAME');
            $db_password = env('DB_PASSWORD');

            echo $db_host, $db_database, $db_username, $db_password;
         ?>
    </ul>
</body>
</html>