window.onscroll = function () {
    fix_nav_bar()
};


function fix_nav_bar() {
    if (window.scrollY > 300) {
        $(".img-logo").css("width", "50px");


    } else {
        $(".img-logo").css("width", "100px");

    }
}

// semantic 

$(document).ready(function () {
    var valid_email;
    //display the modal form 
    $('.logout').click(function () {
        var logout = $.trim($('.logout').text());

        if (logout == "Logout") {
            var href = 'homepage.php?user_logout=true';
            window.location = href;
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
                } else  {
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
  

    // $("$user_login").on('blur',function () {
    //     var username = $('#email').val(); // get the content of what user typed ( in textarea ) 
    //     var password = $('#passwd').val(); // get the content of what user typed ( in textarea ) 
    //     $.ajax({
    //         type: "POST",
    //         url: "homepage.php",
    //         data: "login_email=" + username + "&login_passwd=" + password,
    //         dataType: "json",
    //         success: function (data) {
    //             var success = data['success'];
    //             if (success == false) {
    //                 var error = data['message'];
    //                 alert(error); // just in case somebody to click on share witout writing anything :


    //             }

    //             if (success == true) {

    //                 setTimeout("location.href = 'homepage.php';", 1000);
    //             }
    //         }

    //     }); //end ajax             
    // }); //end click function
}); //end ready function