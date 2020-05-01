window.onscroll = function () {

    fix_nav_bar();
    countable_number();

};

function countable_number() {
    if (window.scrollY > 3000) {
        var amount = 5000;
        $({
            countNum: 0 //starting point of existing cache
        }).animate({
            countNum: amount //ending
        }, {
            duration: 600,
            easing: 'linear',
            step: function () {
                $('.customer').html(Math.ceil(this.countNum));
            },
            complete: function () {
                $('.customer').html(amount);
                //alert('finished');
            }
        });

    }
}

function fix_nav_bar() {
    if (window.scrollY > 300) {
        $(".img-logo").css("width", "50px");


    } else {
        $(".img-logo").css("width", "100px");

    }
}



$(document).ready(function () {

    //display the modal form 

    $('.logout').click(function () {
        var logout = $.trim($('.logout').text());

        if (logout == "Logout") {
            var href = 'homepage.php?user_logout=true';
            window.location = href;
        }
    });
    //display login modal form when the user is logout
    $('.favorite').click(function () {
        var logout = $.trim($('.logout').text());

        if (logout == "Logout") {
            var href = 'favorite.php';
            window.location = href;
        } else {
            $('.logout').click();
            return false;
        }
    });
 
    $('.procced').click(function () {
        var logout = $.trim($('.logout').text());

        if (logout == "Logout") {
            var href = $('.procced').attr("data-href");
            window.location = href;
        } else {
            $('.logout').click();
            return false;
    
        }
    });
    $('.basket').click(function () {
        var logout = $.trim($('.logout').text());

        if (logout == "Logout") {
            var href = 'basket.php';
            window.location = href;
        } else {
            $('.logout').click();
            return false;
        }
    });
    $('.wish_list').click(function () {
        var logout = $.trim($('.logout').text());

        if (logout == "Logout") {
            var href = 'wish_list.php';
            window.location = href;
        } else {
            $('.logout').click();
            return false;
        }
    });
    //valid email

    //check the email if is valid
    $('#sign_up_email').on('blur', function (e) {
        e.preventDefault();
        var email = $('#sign_up_email').val();

        $.ajax({
            url: 'sign_up_form.php',
            type: 'POST',
            data: {
                'email_ajax': email
            },

            beforeSend: function () {
                $("#email_result").html('<div class="ui active inline loader"></div>');
            },
            success: function (response) {
                // alert(response.d);
                if (response == true) {
                    $("#email_result").text('Invalid email').addClass('text-danger');
                } else {
                    $("#email_result").text('Email correct').removeClass('text-danger');
                }
            },

        });
    });
    $('#tel_ajax').on('blur', function (e) {
        var tel = $('#tel_ajax').val();

        $.ajax({
            url: 'sign_up_form.php',
            type: 'POST',
            data: {
                'tel_ajax': tel,
            },
            beforeSend: function () {
                $("#tel_result").html('<div class="ui active inline loader"></div>');
            },
            success: function (response) {
                if (response == true) {
                    // alert(response);
                    $('#tel_result').show().text('Invalid telephone').addClass('text-danger');
                } else {
                    $('#tel_result').show().text('Telephone correct').removeClass('text-danger');
                }
            }
        });
    });
    $('#sign_up').click(function () {
        if ($('#passwd').val() != $('#re_passwd').val()) {
            $('#passwd_valid').text('Password are not same');
            return false;
        }
    })



}); //end ready function