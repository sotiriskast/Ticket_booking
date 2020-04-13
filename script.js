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
      $('.logout').click(function() {
                    var logout = $.trim($('.logout').text());
                    
                    if(logout=="Logout"){
                        var href='homepage.php?user_logout=true';
                        window.location =href;
                    }
                });
                

    // $("$user_login").click(function () {
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