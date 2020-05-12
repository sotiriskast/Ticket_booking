<?php
session_start();
require_once 'function.php';



// if ($sl->rowCount() == 1) {
//     $_SESSION['login'] = $_POST['username'];
// } else {
//     $error = 'invalid username or password';
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="image_src" type="image/png" href="https://res.cloudinary.com/sotiris/image/upload/v1586768666/Tour_Excursion/logo_f9ozsq.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Excursion" />
    <title>Chorkoiris Tour Excursion | Book Now</title>
    <link rel="shortcut icon" href="https://res.cloudinary.com/sotiris/image/upload/v1586768666/Tour_Excursion/logo_f9ozsq.png" type="image/x-icon" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="../semantic/dist/semantic.min.css">
    <link rel="stylesheet" href="../semantic/dist/components/dropdown.css">
    <script src="../semantic/dist/semantic.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anony1mous">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />



    <link rel="stylesheet" href="../css/style.css">

    <style>
        a.navbar-brand {
            position: fixed;
            left: 50%;
            top: 0;
            transform: translate(-50%);
        }
    </style>
</head>

<body>

    <?php
    require_once 'login_form.php';
    require_once 'navigation_bar.php';
  
    ?>

    <div class="slideshow">
        <video width="100%" height="100%" controls autoplay muted loop>
            <source src="https://res.cloudinary.com/sotiris/video/upload/v1586445077/Hotel%20Vrissiana/Cyprus_welcomes_the_world__fhvkiv.mp4" frameborder="0" allowfullscreen type="video/mp4">
        </video>
    </div>


    <section class="ui overview bg-light pb-5">
        <div class="ui content-overview  p-5 m-auto text-center">
            <h1>Welcome to Cyprus</h1>
            <p>

                Cyprus is located east of Greece (Kastellorizo), south of Turkey, west of Syria and north of Egypt.
                Cyprus is the third largest island in the Mediterranean.
            </p>
            <p>
                Geographically, Cyprus belongs to the Middle East, however, because Cyprus has historically, culturally
                and economically linked to Europe and particularly to Greece, it is considered to be only part of the
                West but also of Europe. Today it is considered the southeast edge of the European Union and of the
                whole of Europe.</p>
            <p>
                The inhabitants of Cyprus are ranked according to their origin, language, cultural tradition and
                religion in one of the two communities provided by Article 2 of the Constitution of the Republic of
                Cyprus, either Greek or Turkish. The majority of Cypriot residents today, including the three recognized
                religious groups of the Maronites, Armenians and Latins (Catholics), are 78% of the Greek community.
                There are also a large number of foreign citizens living in Cyprus, who at the end of 2011, according to
                the official census, accounted for 21.4% of its population.
            </p>
        </div>
    </section>


    <?php include_once  'popular_event.php'; ?>
    <hr>
    <?php include_once 'recent_event.php';
     ?>
    <section class="ui overview bg-light pb-5">

        <div class="ui segment p-5" style="background-color: transparent">
            <div class="ui two column very relaxed grid">
                <div class="column">
                    <h1>Why Book With Us?</h1>
                    <p class="mt-5 mb-5"></p>
                    <p class="mt-5"> <i class="thumbs up outline icon blue"></i>All places and activities are carefully by us</p>
                    <p><i class="euro sign  icon blue"></i>Best price guarantee &amp; Hassle free!</p>
                    <p><i class="star outline  icon blue"></i>We are an award winning agency</p>
                    <p><i class="mobile alternate icon  blue"></i>24/7 Global support</p>
                    <p><i class="tripadvisor icon blue"></i>A Trip advisor Company</p>
                    <button class="ui primary button">
                        Find out More!
                    </button>
                </div>
                <div class="column ">
                    <div class="w-100 "><img width="100%" height="100%" src="https://www.creative.com.cy/wp-content/uploads/2017/03/halloumi.jpg" alt="" srcset=""></div>

                </div>
            </div>

        </div>
    </section>
    <section class="ui overview pb-5 text-center">
        <h1>We are featured in</h1>
        <div class="ui container-fluid">
            <div class="ui mt-5 row row-col-4">
                <div class="col">
                    <p class="h2 click_trusted">Trusted by <span class="customer">0</span>
                </div>
                <div class="col">
                    <p class="h2">Review <span class="review">0</span> +</p>
                </div>
                <div class="col">
                    <p class="h2">Sales <span class="sales">0</span> +</p>
                </div>
            </div>
        </div>
        <script>
            $(".click_trusted").on('click', function(e) {
                alert(e.preventDefault);
                $({
                    countNum: 0 //starting point of existing cache
                }).animate({
                    countNum: 5000 //ending
                }, {
                    duration: 400,
                    easing: 'swing',
                    step: function() {
                      
                        $('.customer').html(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $('.customer').html(5000);
                
                        //alert('finished');
                    }
                });
                //saveAsNewName(amount)
            });
        </script>
        <div style="height:10vh"></div>




    </section>

    <?php include_once('footer.html') ?> 
    <script src="../script.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>