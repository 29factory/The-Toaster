<?php

define("SCREEN_MAINMENU", 0);
define("SCREEN_LOGIN", 1);
define("SCREEN_SIGNUP", 2);
define("SCREEN_PROFILE", 3);
define("SCREEN_GAME", 4);
define("SCREEN_PAUSE", 5);
define("SCREEN_ABOUT", 6);

function screen($scr)
{
?>
    <div id="<?= ["main-menu", "login", "signup", "profile", "game", "pause", "about"][$scr] ?>" class="screen scene" style="display: none;">
        <div style="position: relative; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
            <div class="container centered window text-center">
                <?php if ($scr == SCREEN_MAINMENU): ?>
                    <h1 class="text-center">The Toaster<br>
                        <small>
                            <?php if (isset($_SESSION["login"])): ?>Welcome, <a role="button" onclick="scene(STATE_PROFILE);"><?= $_SESSION["login"] ?></a><?php else: ?><a role="button" onclick="scene(STATE_LOGIN)">Login</a><?php endif; ?>
                        </small>
                    </h1>
                    <button type="button" class="btn btn-menu" onclick="scene(STATE_GAME);">Toastbox</button>
                    <button type="button" class="btn btn-menu" disabled>Time-limit</button>
                    <button type="button" class="btn btn-menu" disabled>Toast-limit</button>
                    <button type="button" class="btn btn-menu" disabled>Hardcore</button>
                <?php elseif ($scr == SCREEN_LOGIN): ?>
                    <h2 class="text-center">Login <small><a role="button" onclick="scene(STATE_SIGNUP);">Sign Up</a></small></h2>
                    <form method="post" action="auth.php">
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
                <?php elseif ($scr == SCREEN_SIGNUP): ?>
                    <h2 class="text-center">Sign Up</h2>
                    <form method="post" action="auth.php">
                        <input type="hidden" name="q" value="signup">
                        <div class="form-group">
                            <label for="signup-login-input">Login</label>
                            <input type="text" class="form-control" id="signup-login-input" name="login" placeholder="Login">
                        </div>
                        <div class="form-group">
                            <label for="signup-pass-input">Password</label>
                            <input type="password" class="form-control" id="signup-pass-input" name="pass" placeholder="Password">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                            <button type="button" class="btn btn-danger" onclick="scene(STATE_MAINMENU);">Cancel</button>
                        </div>
                    </form>
                <?php elseif ($scr == SCREEN_ABOUT): ?>
                    <div class="row" style="padding-bottom: 10px;">
                        <div style="text-align:left; position: absolute; height: 50px; width: 50px; float: left; margin: 0; margin-left: 10px; padding: 10px; background-color: #6595ed;">
                            <img style="height: 30px; width: 30px;" src="assets/icons/about.svg">
                        </div>
                        <h2 class="text-center">About<br><small style="opacity: .6;">Version 0.6.0</small></h2>
                    </div>
                    <div>
                        <p style="text-align:left;">The Toaster created by 29FACTORY Team to make your Internet more enjoyable.</p>
                        <p style="text-align:left;">Want to help? You can <a href="http://vk.com/thetoaster">contact us</a> and join our community!</p>
                    </div>
                    <div style="margin-top: 30px; margin-bottom: 10px;">
                        <button type="button" class="btn btn-menu" onclick="scene(STATE_MAINMENU);">Back</button>
                    </div>
                    <p><small style="opacity: .5;">29FACTORY TEAM, 2015</small></p>
                <?php elseif ($scr == SCREEN_PROFILE && isset($_SESSION["login"])): ?>
                    <h2 class="text-center"><?= $_SESSION["login"] ?></h2>
                    <form method="post" action="auth.php">
                        <input type="hidden" name="q" value="logout">
                        <button type="button" class="btn btn-primary" onclick="scene(STATE_MAINMENU);">OK</button>
                        <input type="submit" class="btn btn-danger" value="Logout">
                    </form>
                <?php elseif ($scr == SCREEN_GAME): ?>
                    <div class="row">
                        <div style="text-align:left; position: absolute;">
                             <button type="button" class="btn btn-icon btn-menu btn-small" style="background-image: url(assets/icons/pause.svg); margin-left: 10px;" onclick="scene(STATE_PAUSE);"></button>
                        </div>
                        <h2 class="text-center text-uppercase" id="title-score">Score: <span id="score">0</span></h2>
                    </div>
                    <img id="image" style="width: 200px; height: 200px;" src="assets/toaster-empty.svg">
                    <div class="row">
                        <button type="button" class="btn btn-ingame btn-icon" style="background-image: url(assets/icons/make.svg);" onclick="game.makeToast();"></button>
                        <button type="button" class="btn btn-ingame btn-icon" style="background-image: url(assets/icons/change.svg);" onclick="game.changeBread();"></button>
                    </div>
                <?php elseif ($scr == SCREEN_PAUSE): ?>
                    <h2 class="text-center">The Toaster <small>Paused</small></h2>
                    <div class="row">
                        <button type="button" class="btn btn-menu btn-icon" style="background-image: url(assets/icons/resume.svg);" onclick="scene(STATE_GAME);"></button>
                        <button type="button" class="btn btn-menu btn-icon" style="background-image: url(assets/icons/quit.svg);" onclick="scene(STATE_MAINMENU);"></button>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($scr == SCREEN_GAME): ?>
                <div id="achievement" class="container window" style="opacity: 0; display: none;">
                    <div style="width: 80px; height: 80px; float: left; margin: 10px; margin-left: -10px; padding: 10px; background-color: #FF2A2A;">
                        <img src="assets/icons/achievement.svg">
                    </div>
                    <h3>Achievement get!</h3>
                    <h4 id="achievement-text">You don`t see it</h4>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($scr == SCREEN_MAINMENU): ?>
            <div style="position: absolute; bottom: 0; left: 50%; transform: translate(-50%, 0); background-color: white; padding: 5px 10px;">
                <a href="https://trello.com/b/wWsquiZ0/the-toaster">Changelog</a> | <a role="button" onclick="scene(STATE_ABOUT);">About</a>
            </div>
        <?php endif; ?>
    </div>
<?php
}
