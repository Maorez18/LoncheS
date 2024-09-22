$(document).ready(function() {
    if ($(window).width() >= 992) {
        $('#largeScreenContent').show();
        $('#mediumScreenContent').hide();
        $('#smallScreenContent').hide();
    } else {
        if ($(window).width() >= 576 && $(window).width() <922){
            $('#largeScreenContent').hide();
            $('#mediumScreenContent').show();
            $('#smallScreenContent').hide();
        } else {
            if ($(window).width() < 576){
                $('#largeScreenContent').hide();
                $('#mediumScreenContent').hide();
                $('#smallScreenContent').show();
            }
        }
    }

    $(window).resize(function() {
        if ($(window).width() >= 992) {
            $('#largeScreenContent').show();
            $('#mediumScreenContent').hide();
            $('#smallScreenContent').hide();
        } else {
            if ($(window).width() >= 576 && $(window).width() <922){
                $('#largeScreenContent').hide();
                $('#mediumScreenContent').show();
                $('#smallScreenContent').hide();
            } else {
                if ($(window).width() < 576){
                    $('#largeScreenContent').hide();
                    $('#mediumScreenContent').hide();
                    $('#smallScreenContent').show();
                }
            }
        }
    });
});

var navlg = document.getElementById('navbar-lg');
window.addEventListener('scroll', function(){
    if(window.pageYOffset > 100){
        navlg.classList.add('bg-trans');
    }else{
        navlg.classList.remove('bg-trans');
    }
})

var navmd = document.getElementById('navbar-md');
window.addEventListener('scroll', function(){
    if(window.pageYOffset > 50){
        navmd.classList.add('bg-trans');
    }else{
        navmd.classList.remove('bg-trans');
    }
})