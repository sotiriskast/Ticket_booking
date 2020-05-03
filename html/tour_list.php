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


    <link rel="stylesheet" type="text/css" href="../semantic/dist/semantic.min.css">
    <link rel="stylesheet" href="../semantic/dist/components/rating.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="../semantic/dist/components/rating.js"></script>

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

    <section class="container-fluid p-0 mb-5" style="height:70vh">
        <img src="https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60" width="100%" height="100%" alt="">
    </section>
    <div class="container">
        <div class=" three ui buttons big">
            <a class="ui button" href="tour_list.php?sort=null">Overview</a>
            <a class="ui button" href="tour_list.php?sort=asc">
                <div class="ui range" id="my-range"><i class="filter icon"></i>Sort by min. Price</div>
            </a>
            <a id="tour" class="ui button" href="tour_list.php?sort=desc"><i class="filter icon"></i>Sort by max. Price</a>
        </div>
        <?php

        foreach (get_all_excursion($_REQUEST['sort']) as $e) {
            //position 0 (price)
            //position 1 (date)
            //position 2 (starting point)
            //position 3 (time)
            //position 4 (image)
            //position 5 (title)
            //position 6 (description)
            //position 7 (rating)
            //position 8 (Duration)
            $show = <<<print
            <div class="ui icon message mt-3">
            <div class="img-fluid w-25 h-25">
                <img src="{$e[4]}" width="100%" height="100%" alt="">
            </div>
            <div class="content w-25">
                <div class="header pl-3">
                    <p>{$e[5]}</p>
                </div>
                <div class="pl-3">
                    <div class="ui star rating" data-rating="{$e[7]}" data-max-rating="5"></div><span>({$e[7]})</span>
                </div>
            </div>
            <div class="content ">
                <div class="ui large  transparent left icon">
                    <div class="m-auto w-50">
                        <p>From: <i class="euro icon"></i>{$e[0]}</p>
                        <p><a href="tour_details.php?title={$e[9]}" class="ui violet button"> Learn more</a></p>
                        <p class="ui small p-0 m-0"><i class="time outline icon"></i>Duration: {$e[8]}</p>
                        <p class="ui small p-0 m-0"><i class="lock icon"></i>Reserved now &amp; Pay Later</p>
                        <p class="ui small p-0 m-0"><i class="check icon"></i>Free cancelation</p>
                    </div>
                </div>
            </div>
        </div>
print;
            echo $show;
        }
        ?>
        <script id="dd">
            $('.ui.rating').rating('disable')
        </script>
    </div>
    <div style="height: 10vh"></div>
    <?php include_once('footer.html') ?>
    <script src="../script.js"></script>
    <script src="../semantic/dist/semantic.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>