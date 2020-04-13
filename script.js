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
$('.ui.dropdown').dropdown();
