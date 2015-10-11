const STATE_MAINMENU = 0;
const STATE_LOGIN = 1;
const STATE_SIGNUP = 2;
const STATE_GAME = 3;
const STATE_PAUSE = 4;
const STATE_PROFILE = 5;

const GAMEMODE_TOASTBOX = 0;

const STATUS_EMPTY = 0;
const STATUS_BREAD = 1;
const STATUS_TOAST = 2;
const STATUS_COAL = 3;

const ajax = new XMLHttpRequest();

var game = {
    achievements : {},
    state : STATE_MAINMENU,
    toasterStatus : STATUS_EMPTY,
    updateStatus : function (s) {
        if (s == STATUS_TOAST) {
            game.score++;
            if (game.achievements[game.score]) {
                game.achieve(game.score);
                delete game.achievements[game.score];
            }
        }
        else if (s == STATUS_COAL) {
            game.score--;
            var score_title = document.getElementById("title-score");
            score_title.classList.add("animation-burn");
            score_title.addEventListener("animationend", function () {score_title.classList.remove("animation-burn")});
        }
        updateScore();
        game.toasterStatus = s;
        updateImage();
    },
    makeToast : function () {
        if (game.toasterStatus == STATUS_BREAD) game.updateStatus(STATUS_TOAST);
        else if (game.toasterStatus == STATUS_TOAST) game.updateStatus(STATUS_COAL);
    },
    changeBread : function () {
        game.updateStatus(STATUS_BREAD);
    },
    endgame : function () {
        ajax.open("GET", "game.php?q=endgame&score="+game.score+"&gamemode="+GAMEMODE_TOASTBOX, true);
        ajax.onreadystatechange = function () {if (ajax.readyState == 4) {ajax.onreadystatechange = null;}};
        ajax.send();
        game.score = 0;
        game.toasterStatus = STATUS_EMPTY;
        updateScore();
        updateImage();
    },
    achieve : function () {
        console.log(game.achievements[game.score]);
        ajax.open("GET", "game.php?q=achievements.set&id="+game.score, true);
        ajax.onreadystatechange = function () {if (ajax.readyState == 4) {ajax.onreadystatechange = null;}};
        ajax.send();
    }
};

function updateScore() {
    document.getElementById("score").innerHTML = game.score;
}

function updateImage() {
    if (game.toasterStatus == STATUS_EMPTY) document.getElementById("image").setAttribute("src", "assets/toaster-empty.svg");
    else if (game.toasterStatus == STATUS_BREAD) document.getElementById("image").setAttribute("src", "assets/toaster-bread.svg");
    else if (game.toasterStatus == STATUS_TOAST) document.getElementById("image").setAttribute("src", "assets/toaster-toast.svg");
    else if (game.toasterStatus == STATUS_COAL) document.getElementById("image").setAttribute("src", "assets/toaster-coal.svg");
}

function scene(nextState) {
    if (game.state == STATE_MAINMENU) {
        if (nextState == STATE_PROFILE || STATE_GAME) {
            document.getElementById("main-menu").style.display = "none";
        }
    } else if (game.state == STATE_PAUSE) {
        if (nextState == STATE_GAME) document.getElementById("pause").style.display = "none";
        else if (nextState == STATE_MAINMENU) {
            game.endgame();
            document.getElementById("pause").style.display = "none";
            document.getElementById("game").style.display = "none";
        }
    } else if (game.state == STATE_LOGIN) {
        document.getElementById("login").style.display = "none";
    } else if (game.state == STATE_PROFILE) {
        document.getElementById("profile").style.display = "none";
    } else if (game.state == STATE_SIGNUP) {
        document.getElementById("signup").style.display = "none";
    }
    game.state = nextState;
    if (game.state == STATE_MAINMENU) {
        document.getElementById("main-menu").style.display = "";
    } else if (game.state == STATE_GAME) {
        document.getElementById("game").style.display = "";
    } else if (game.state == STATE_PAUSE) {
        document.getElementById("pause").style.display = "";
    } else if (game.state == STATE_LOGIN) {
        document.getElementById("login").style.display = "";
    } else if (game.state == STATE_PROFILE) {
        document.getElementById("profile").style.display = "";
    } else if (game.state == STATE_SIGNUP) {
        document.getElementById("signup").style.display = "";
    }
}

ajax.open("GET", "game.php?q=achievements.get");
ajax.onreadystatechange = function () {
    if (ajax.readyState == 4) {
        if (ajax.status == 200) {
            game.achievements = JSON.parse(ajax.responseText);
        }
        ajax.onreadystatechange = null;
    }
};
ajax.send();

game.score = 0;
game.toasterStatus = STATUS_EMPTY;
updateScore();
updateImage();
scene(STATE_MAINMENU);
