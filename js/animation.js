var main = function() {
    $('.btn-pause').click(function(){
        $('.score').hide();
        $('.pause').show();
    });

    $('.btn-resume').click(function(){
        $('.pause').hide();
        $('.score').show();
    });

    $('.btn-help').click(function(){
        $('.achievement').animate({
            top: "0px"
        }, 200);
        setTimeout(function(){
            $('.achievement').animate({
                top: "-95px"
            }, 200);
        },3000);

    });
};

$(document).ready(main);