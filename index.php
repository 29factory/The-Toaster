<?php

include_once "templates.php";

session_start();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>The Toaster</title>
    <meta name="viewport" content="initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animations.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
</head>
<body>
<?php screen(SCREEN_MAINMENU); ?>
<?php screen(SCREEN_LOGIN); ?>
<?php screen(SCREEN_SIGNUP); ?>
<?php screen(SCREEN_PROFILE); ?>
<?php screen(SCREEN_GAME); ?>
<?php screen(SCREEN_PAUSE); ?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/common.js"></script>
</body>
</html>
