<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Document</title>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../semantic/dist/semantic.min.css">
    <link rel="stylesheet" href="../semantic/dist/components/dropdown.css">
    <script src="../semantic/dist/semantic.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anony1mous">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top ">
        <a class="navbar-brand img-logo" href="#"><img src="https://res.cloudinary.com/sotiris/image/upload/v1586768666/Tour_Excursion/logo_f9ozsq.png" width="100%" height="100%" alt="" srcset=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tour List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Aboout us</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact us</a>
                </li>
            </ul>
            <div class="navbar-nav">
                <a class="nav-link " href="#">
                    <i class="cart arrow down icon"></i>
                    Basket
                </a>
                </a>
                <a class="nav-link" href="#">
                    <i class=" heart outline icon"></i>
                    Favorite
                </a>
                <a class="nav-link" href="#">
                    <i class=" user circle outline icon"></i>
                    Login
                </a>

            </div>
        </div>
    </nav>
    <div class="slideshow">
        <video width="100%" height="100%" controls autoplay muted>
            <source src="https://res.cloudinary.com/sotiris/video/upload/v1586445077/Hotel%20Vrissiana/Cyprus_welcomes_the_world__fhvkiv.mp4" frameborder="0" allowfullscreen type="video/mp4">
        </video>
    </div>


    <section class="ui overview bg-light pb-5">
        <div class="ui content-overview pt-5 m-auto text-center">
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
    <section class="ui container w-100 pb-5">
        <div class="ui w-75 pt-5 m-auto text-center">
            <h1> <i class="gem outline icon" style="color: #007bff;"></i>Popular places</h1> <a class="ml-3" href="$">View all places</a>
            <div class="ui container-fluid">
                <div class="ui mt-5 row">
                    <div class="col" style="width: max-content">
                        <div class="ui  image ">
                            <div class="ui blue ribbon label z-index-1000 mt-1">
                                Popular
                            </div>
                            <div class="ui card">
                                <div class="content"></div>
                                <div class="image">
                                    <img src="https://www.creative.com.cy/wp-content/uploads/2017/03/halloumi.jpg">
                                </div>
                                <div class="content">
                                    <span class="right floated">
                                        <i class="euro icon"></i>
                                        46</span>
                                    </span>
                                    <span class="left floated">

                                        Salamis
                                    </span>

                                </div>
                                <div class="extra content ">
                                    <div class="ui large  transparent left icon input">

                                        <a class="w-100 " href="http://">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="ui image ">
                            <div class="ui blue ribbon label z-index-1000 mt-1">
                                Popular
                            </div>
                            <div class="ui card">
                                <div class="content"></div>
                                <div class="image">
                                    <img src="https://www.creative.com.cy/wp-content/uploads/2017/03/halloumi.jpg">
                                </div>
                                <div class="content">
                                    <span class="right floated">
                                        <i class="heart outline like icon"></i>
                                        17 likes
                                    </span>
                                    <i class="comment icon"></i>
                                    3 comments
                                </div>
                                <div class="extra content">
                                    <div class="ui large transparent left icon input">
                                        <i class="heart outline icon"></i>
                                        <input type="text" placeholder="Add Comment...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="ui  image ">
                            <div class="ui blue ribbon label z-index-1000 mt-1">
                                Popular
                            </div>
                            <div class="ui card">
                                <div class="content"></div>
                                <div class="image">
                                    <img src="https://www.creative.com.cy/wp-content/uploads/2017/03/halloumi.jpg">
                                </div>
                                <div class="content">
                                    <span class="right floated">
                                        <i class="heart outline like icon"></i>
                                        17 likes
                                    </span>
                                    <i class="comment icon"></i>
                                    3 comments
                                </div>
                                <div class="extra content">
                                    <div class="ui large transparent left icon input">
                                        <i class="heart outline icon"></i>
                                        <input type="text" placeholder="Add Comment...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ui overview bg-light pb-5">

        <div class="ui segment p-5" style="background-color: transparent">
            <div class="ui two column very relaxed grid">
                <div class="column">
                    <h1>Why Book With Us?</h1>
                    <p class="mt-2 mb-2">s</p>
                    <p class="mt-5"> <i class="thumbs up outline icon blue"></i>All places and activities are carefully by us</p>
                    <p><i class="euro sign  icon blue"></i>Best price guarantee &amp; Hassle free!</p>
                    <p><i class="star outline  icon blue"></i>We are an award winning agency</p>
                    <p><i class="heart outline  icon blue"></i>Trusted by more than 80.000 customers</p>
                    <button class="ui primary button">
                        Find out More!
                    </button>
                </div>
                <div class="column ">
                    <div class="w-100 "><img width="100%" height="100%" src="https://www.creative.com.cy/wp-content/uploads/2017/03/halloumi.jpg" alt="" srcset=""></div>

                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                </div>
            </div>

        </div>
    </section>
    <section class="ui overview pb-5 text-center">
        <h1>We were featured in</h1>
        <div class="ui container-fluid">
            <div class="ui mt-5 row row-col-4">
                <div class="col ">
                <div class="w-25 "><img width="100%" height="100%" src="https://w0.pngwave.com/png/288/367/forbes-logo-others-png-clip-art.png" alt="" srcset=""></div>
                </div>
                <div class="col ">
                <div class="w-25 "><i class="tripadvisor icon massive green"></i></div>
                </div>
                <div class="col ">
                <div class="w-25 "><img width="100%" height="100%" src="https://www.awardslimo.com/wp-content/uploads/Awards-Limousine-Service-Inc-Logo-retina.png" alt="" srcset=""></div>
                </div>
                <div class="col ">
                <div class="w-25 "><img width="100%" height="100%" src="https://blog.tui.co.uk/wp-content/uploads/2016/07/bta2016_vote_online_500px-e1467625496990.png" alt="" srcset=""></div>
                </div>

            </div>
        </div>
        <div style="height:100vh"></div>








        <script src="../semantic/dist/components/dropdown.js"></script>
        <script src="../script.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>