<?php

session_start();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1">
    <title>The Toaster</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="main-menu" class="screen scene" style="display: none;">
    <div style="position: relative; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
        <div class="container centered window">
            <h1 class="text-center">The Toaster<br>
                <small>
                    <?php if (isset($_SESSION["login"])): ?>Welcome, <a role="button" onclick="scene(STATE_PROFILE)"><?= $_SESSION["login"] ?></a><?php else: ?><a role="button" onclick="scene(STATE_LOGIN)">Login</a><?php endif; ?>
                </small>
            </h1>
            <button type="button" class="btn btn-primary btn-main-menu" onclick="scene(STATE_GAME);">Toastbox</button>
            <button type="button" class="btn btn-primary btn-main-menu" disabled>Time-limit</button>
            <button type="button" class="btn btn-primary btn-main-menu" disabled>Toast-limit</button>
            <button type="button" class="btn btn-danger btn-main-menu" disabled>Hardcore</button>
        </div>
    </div>
    <div style="position: absolute; bottom: 0; right: 0; background-color: white; padding: 5px 10px;">
        <a href="changelog.txt">Changelog</a>
    </div>
</div>
<div id="login" class="screen scene" style="display: none;">
    <div style="position: relative; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
        <div class="container centered window text-center">
            <h2 class="text-center">Login</h2>
            <form method="get" action="auth.php">
                <input type="hidden" name="q" value="login">
                <div class="form-group">
                    <label for="login-input">Login</label>
                    <input type="text" class="form-control" id="login-input" name="login" placeholder="Login">
                </div>
                <div class="form-group">
                    <label for="pass-input">Password</label>
                    <input type="password" class="form-control" id="pass-input" name="pass" placeholder="Password">
                </div>
                <div style="margin-bottom: 10px;">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <button type="button" class="btn btn-danger" onclick="scene(STATE_MAINMENU)">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="profile" class="screen scene" style="display: none;">
    <div style="position: relative; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
        <div class="container centered window text-center">
            <h2 class="text-center"><?= $_SESSION["login"] ?></h2>
            <form method="get" action="auth.php">
                <input type="hidden" name="q" value="logout">
                <button type="button" class="btn btn-primary" onclick="scene(STATE_MAINMENU);">OK</button>
                <input type="submit" class="btn btn-danger" value="Logout">
            </form>
        </div>
    </div>
</div>
<div id="game" class="screen scene" style="display: none;">
    <div style="position: relative; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
        <div class="container centered window text-center">
            <h2 class="text-center text-uppercase">Score: <span id="score">0</span></h2>
            <img id="image" style="width: 200px; height: 200px;" src="assets/toaster-empty.svg">
            <div class="row">
                <button type="button" class="btn btn-success btn-icon" style="background-image: url(assets/icons/make.svg);" onclick="game.makeToast();"></button>
                <button type="button" class="btn btn-success btn-icon" style="background-image: url(assets/icons/change.svg);" onclick="game.changeBread();"></button>
                <button type="button" class="btn btn-primary btn-icon" style="background-image: url(assets/icons/pause.svg);" onclick="scene(STATE_PAUSE);"></button>
            </div>
        </div>
    </div>
</div>
<div id="pause" class="screen scene" style="display: none;">
    <div style="position: relative; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
        <div class="container centered window text-center">
            <h2 class="text-center">The Toaster <small>Paused</small></h2>
            <div class="row">
                <button type="button" class="btn btn-primary btn-icon" style="background-image: url(assets/icons/resume.svg);" onclick="scene(STATE_GAME);"></button>
                <button type="button" class="btn btn-primary btn-icon" style="background-image: url(assets/icons/quit.svg);" onclick="scene(STATE_MAINMENU);"></button>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/common.js"></script>
</body>
</html>