const STATE_MAINMENU = 0;
const STATE_LOGIN = 1;
const STATE_GAME = 2;
const STATE_PAUSE = 3;
const STATE_PROFILE = 4;

const GAME_TOASTBOX = 0;

const STATUS_EMPTY = 0;
const STATUS_BREAD = 1;
const STATUS_TOAST = 2;
const STATUS_COAL = 3;

var game = {
    state : STATE_MAINMENU,
    updateStatus : function (s) {
        game.toasterStatus = s;
        updateImage();
    },
    makeToast : function () {
        if (game.toasterStatus == STATUS_BREAD) game.updateStatus(STATUS_TOAST);
        else if (game.toasterStatus == STATUS_TOAST) game.updateStatus(STATUS_COAL);
    },
    changeBread : function () {
        if (game.toasterStatus == STATUS_TOAST) game.score++;
        game.updateStatus(STATUS_BREAD);
        updateScore();
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
        if (nextState != STATE_LOGIN) {
            document.getElementById("main-menu").style.display = "none";
            game.score = 0;
            game.toasterStatus = STATUS_EMPTY;
            updateScore();
            updateImage();
        }
    } else if (game.state == STATE_PAUSE) {
        if (nextState == STATE_GAME) document.getElementById("pause").style.display = "none";
        else if (nextState == STATE_MAINMENU) {
            document.getElementById("pause").style.display = "none";
            document.getElementById("game").style.display = "none";
        }
    } else if (game.state == STATE_LOGIN) {
        document.getElementById("login").style.display = "none";
    } else if (game.state == STATE_PROFILE) {
        document.getElementById("profile").style.display = "none";
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
    }
}

document.createElement("img").setAttribute("src", "assets/toaster-empty.svg");
document.createElement("img").setAttribute("src", "assets/toaster-bread.svg");
document.createElement("img").setAttribute("src", "assets/toaster-toast.svg");
document.createElement("img").setAttribute("src", "assets/toaster-coal.svg");
document.createElement("img").setAttribute("src", "assets/icons/change.svg");
document.createElement("img").setAttribute("src", "assets/icons/make.svg");
document.createElement("img").setAttribute("src", "assets/icons/pause.svg");
document.createElement("img").setAttribute("src", "assets/icons/quit.svg");
document.createElement("img").setAttribute("src", "assets/icons/resume.svg");
scene(STATE_MAINMENU);