<?php

session_start();
require_once 'function.php';

if (isset($_REQUEST['basket'])) {
    //add in cookied the slected box before check out
    $cookie_name = 'basket';
    $cookie_value = json_decode($_COOKIE['basket']);
    $cookie_value[] = array($_REQUEST['title'], $_REQUEST['date'], $_REQUEST['starting'], $_REQUEST['adults'], $_REQUEST['kids'], $_REQUEST['infants'], $_SESSION['user_login']['member_id']);
    setcookie($cookie_name, json_encode($cookie_value), time() + (86400) * 60, "/"); //valid for two moths 
    $label_badget = '  <p class="ui red circular label">N</p>';
}


if (isset($_REQUEST['title'])) {
    //tracking user where visited and added to cookies
    $cookie_value = json_decode($_COOKIE['browsing']);
    $bool = false;
    foreach ($cookie_value as $e) {

        if ($e[0] == ($_REQUEST['title'])) {
            $bool = true;
        }
    }
    if ($bool != true) {
        $cookie_name = 'browsing';
        $cookie_value[] = array($_REQUEST['title']);
        setcookie($cookie_name, json_encode($cookie_value), time() + (86400) * 60, "/"); //valid for two moths 

    }
    $image = get_images($_REQUEST['title']);
    $excursion = get_single_excursion($_REQUEST['title']);
    $tour = get_tour_excursion($_REQUEST['title']);
    $review = get_review($_REQUEST['title']);
    $title = $_REQUEST['title'];
} else {
    header('Location: tour_list.php');
    die();
}
if (isset($_SESSION['user_login'])) {
    //add or remove from wish list 
    if (is_in_wish_list($_SESSION['user_login']['member_id'], $_REQUEST['title'])) {
        $wash_list = '';
    } else {
        $wash_list = 'outline';
    }
} else {
    $wash_list = 'outline';
}
if (isset($_REQUEST['list']) && $_REQUEST['list'] == 'yes') {
    if (insert_wish_list($_SESSION['user_login']['member_id'], $_REQUEST['title'])) {
        $wash_list = '';
    } else {
        $wash_list = 'outline';
    }
}
if (isset($_REQUEST['submit'])) {
    if (empty($_REQUEST['datapicker'])) {
        $error_availability = 'Please select date';
    } else {
        $tomorrow = date('Y-m-d');
        $selected_date = date('Y-m-d', strtotime($_REQUEST['datapicker']));
        if ($selected_date < $tomorrow) {
            $error_availability = 'Please select date from tomorrow';
        } else {
            $error_availability = '';
            $total_guest = $_REQUEST['adults'] + $_REQUEST['kids'] + $_REQUEST['infants'];
            $availability = dispaly_availability($_REQUEST['title'], $selected_date);
            $lang = get_lanquage($availability[0]['gd_ssn']);
            foreach ($lang as $l) {
                $language .= $l . ' ';
            }
            if (!empty($availability)) {
                foreach ($availability as $e) {
                    $adults = $e['tour_price'] * $_REQUEST['adults'];
                    $kids = (100 - $e['tour_price_kids']) / 100 * $e['tour_price'] * $_REQUEST['kids'];

                    $total_price = $adults + $kids;
                    $count = count_booking($e['tour_id'], $selected_date);
                    if ($count == null) {
                        $count = 0;
                    }
                    if ($availability[0]['exc_availability'] - $count[0][0] > $total_guest) {

                        $av .= <<<print
                    <hr>
        <div class="ui icon message mt-3">
            <div class="img-fluid w-25 h-25">
                <img src="{$image[0][0]}" width="100%" height="100%" alt="">
            </div>
            <div class="content w-25">
                <div class="header pl-3">
                    <p>{$e['exc_title']}</p>
                </div>
                <div class="pl-3">
                    <p >Starting:point: <i class="text-primary"> {$e['tour_starting_point']}</i></p>
                    <p>Date {$e['tour_date']}</p>
                    <p>Time: {$e['tour_time_start']}</p>
                    <p>Booked: {$count[0][0]} out of {$e['exc_availability']}</p>
                    <p>Guide: {$e['gd_name']} {$e['gd_surname']}</p>
                    <p>Languages: {$language}</p>
                </div>
            </div>
            <div class="content ">
                <div class="ui large  transparent left icon">
                    <div class="m-auto w-50">
                        <p>Total: <i class="euro icon"></i>{$total_price}</p>
                        <p><a data-href="tour_details.php?title={$e['exc_id']}&basket='true&date={$selected_date}&adults={$_REQUEST['adults']}&kids={$_REQUEST['kids']}&infants={$_REQUEST['infants']}&starting={$e['tour_starting_point']}"  class="ui violet button procced"> Add to Basket</a></p>
                        <p class="ui small p-0 m-0"><i class="time outline icon"></i>Duration: {$e['exc_duration']}</p>
                        <p class="ui small p-0 m-0"><i class="lock icon"></i>Reserved now &amp; Pay Later</p>
                        <p class="ui small p-0 m-0"><i class="check icon"></i>Free cancelation</p>
                    </div>
                </div>
            </div>
        </div>
print;
                    } else {
                        $av .= <<<print
                            <div class="ui icon message mt-3">
                                <div class="img-fluid w-25 h-25">
                                    <img src="{$image[0]}" width="100%" height="100%" alt="">
                                </div>
                                <div class="content w-25">
                                    <div class="header pl-3">
                                        <p>{$e['exc_title']}</p>
                                    </div>
                                    <div class="pl-3">
                                        <p>Starting:point: {$e['tour_starting_point']}</p>
                                        <p>Date {$e['tour_date']}</p>
                                        <p>Time: {$e['tour_time_start']}</p>
                                        <p>Booked: {$count} out of {{$e['exc_availability']}</p>
                                        <p>Guide: {$e['gd_name']} {$e['gd_surname']}</p>
                                        <p>Languages: {$language}</p>
                                    </div>
                                </div>
                                <div class="content ">
                                    <div class="ui large  transparent left icon">
                                        <div class="m-auto w-50">
                                            <p>Total: <i class="euro icon"></i>{$total_price}</p>
                                            <p class="ui button grey">Not available</>
                                            <p class="ui small p-0 m-0"><i class="time outline icon"></i>Duration: {$e['exc_duration']}</p>
                                            <p class="ui small p-0 m-0"><i class="lock icon"></i>Reserved now &amp; Pay Later</p>
                                            <p class="ui small p-0 m-0"><i class="check icon"></i>Free cancelation</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
print;
                    }
                }
            } else {
                $av = "<p class=\"display-3\">This Excursion is not available for this date </p><p class=\"display-5 text-primary\">Pleas modify your Date and search again</p>";
            }
        }
    }
}


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
    <link rel="stylesheet" href="../semantic/dist/components/dropdown.css">
    <link rel="stylesheet" href="../semantic/dist/components/message.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="../semantic/dist/components/rating.js"></script>
    <script src="../semantic/dist/components/dropdown.js"></script>
    <script src="../semantic/dist/semantic.min.js"></script>


    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

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

<body style="background-color: rgb(238,238,250)">
    <?php
    require_once 'login_form.php';
    require_once 'navigation_bar.php';

    ?>
    <div style="height: 10vh"></div>
    <div class="container-fluid">
        <div class="ui warning message container corona-virus p-4 ">
            <i class="close icon"></i>
            <div class="header">
                <i class="info circle icon red"></i>
                To limit the spread of the coronavirus, attractions may be closed or have partial closures. Please consult government travel advisories before booking.
                The WHO is closely monitoring the coronavirus and more information can be found <a class="ui " href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019">here</a>
            </div>
        </div>
    </div>
    <script>
        $('.corona-virus').on('click', function() {
            $('.corona-virus').remove();
        });
    </script>
    <div class="ui breadcrumb">
        <a class="section" href="homepage.php">Home</a>
        <i class="right chevron icon divider"></i>
        <a class="section" href="tour_list.php">Tour List</a>
        <i class="right arrow icon divider"></i>
        <div class="active section">Tour Information</div>
    </div>
    <div class="container-fluid ">
        <div class="container pb-0 mb-0">
            <div class="row pb-0 mb-0">
                <div class="col pl-5">
                    <p class="display-2"><?php echo $excursion['exc_title']; ?></p>
                </div>
            </div>
            <div class="row pb-0 mb-0">
                <div class="col pl-5">
                    <div class="ui star rating" data-rating="<?php echo round($excursion['average']); ?>" data-max-rating="5"></div><span>( <?php echo round($excursion['average'], 2); ?> ) <a class="btn-link " href="#review"> Total review ( <?php echo round($excursion['total_count'], 0); ?> )</a></span>
                </div>
                <div class="col text-right pr-5">
                    <a class="ui wish_list" style="text-decoration: none" href="tour_details.php?&title=<?php echo $excursion['exc_id']; ?>&list=yes"><i class="ui heart <?php echo $wash_list ?> icon red"></i>Add to Wish list</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-0 mt-0">
        <div class="p-2 m-2">
            <div class="row">
                <div class="col">
                    <div class="container-fluid  bg-light pb-3 pt-3">
                        <form action="tour_details.php" method="GET">
                            <p class="h2"> Price From: <i class="ui euro icon"></i><?php echo $tour[0]['tour_price'] ?></p>
                            <p class="h4">Starting point: <?php echo $tour[0]['tour_starting_point'] ?></p>
                            <div class="ui">
                                <label for="datepicker"> Selectet Day</label>
                                <div class="ui right icon w-100">
                                    <input id="datepicker" type="text" name="datapicker" class="form-control text-form-control" readonly require />
                                </div>
                            </div>
                            <div class="ui">
                                <label for="adults"><span>&starf;</span> Adults (13+)</label>
                                <!--surround the select box with a "custom-select" DIV element. Remember to set the width:-->
                                <select name="adults" id="adults" class="dropdown-select adults" style="width: 100%" required>
                                    <option value="1">1</option>
                                    <option selected value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>


                            <div class="ui">
                                <label for="kids"><span>&starf;</span> Kids (2-12)</label>
                                <select name="kids" id="kids" class="dropdown-select kids" style="width: 100%" required>
                                    <option selected value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>

                            </div>
                            <div class="ui">
                                <label for="last-name"><span>&starf;</span> Infants (0-2)</label>
                                <select name="infants" class="dropdown-select infants" required id="infants" style="width: 100%">
                                    <option selected value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>

                            <script>
                                $('#datepicker').datepicker();
                            </script>
                            <input type="hidden" name="title" value="<?php echo $_REQUEST['title'] ?>">
                            <input class="mt-3 w-100 btn input bg-primary p-2 text-white" type="submit" value="Check Availability" name="submit">
                            <p class="text-danger"><?php echo $error_availability ?></p>
                        </form>
                    </div>
                </div>

                <div class="col-7 ">
                    <div id="carouselExampleControls" class="carousel slide border border-secondary rounded-lg" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $str = '';
                            foreach ($image as $img) {
                                if ($str == null) {
                                    $str = "<div class=\"carousel-item active\"><img src=\"$img[0]\" class=\"d-block w-100\" ></div>";
                                } else {
                                    $str = "<div class=\"carousel-item\"><img src=\"$img[0]\" class=\"d-block w-100\" ></div>";
                                }
                                echo $str;
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="" aria-hidden="true"><i class="arrow left icon black huge"></i></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="" aria-hidden="true"><i class="arrow right icon black huge"></i></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <div class="col">
                    <?php
                    if (count($review) <= 4) {
                        foreach ($review as $e) {
                            $date = date('d/M/Y', strtotime($e['review_date']));
                            if ($e['review_comment'] == null) {
                                $comment = '...';
                            } else {
                                $comment = $e['review_comment'];
                            }
                            $show = <<<print
                               <div class="ui comments">
                               <div class="comment">
                                   <a class="avatar">
                                       <img src="https://res.cloudinary.com/sotiris/image/upload/c_scale,w_100/v1587147826/Tour_Excursion/people-512_xd0wj8.png">
                                   </a>
                                   <div class="content">
                                       <a class="author h4">{$e['member_name']} {$e['member_surname']}</a>
                                       <div class="metadata">
                                           <div class="date">{$date}</div>
                                           <div class="rating">
                                           <div class="ui star rating " data-rating="{$e['review']} " data-max-rating="5"></div><span>({$e['review']})</span>
                                               
                                           </div>
                                       </div>
                                       <div class="text">
                                           {$comment}
                                       </div>
                                   </div>
                               </div>
                           </div>
print;
                            echo $show;
                        }
                    } else {
                        for ($e = 0; $e < 5; $e++) {
                            $date = date('d/M/Y', strtotime($review[$e]['review_date']));
                            if ($review[$e]['review_comment'] == null) {
                                $comment = 'Nothing post';
                            } else {
                                $comment = $review[$e]['review_comment'];
                            }
                            $show = <<<print
                               <div class="ui comments">
                               <div class="comment">
                                   <a class="avatar">
                                       <img src="https://res.cloudinary.com/sotiris/image/upload/c_scale,w_100/v1587147826/Tour_Excursion/people-512_xd0wj8.png">
                                   </a>
                                   <div class="content">
                                       <a class="author h4">{$review[$e]['member_name']} {$review[$e]['member_surname']}</a>
                                       <div class="metadata">
                                           <div class="date">{$date}</div>
                                           <div class="rating">
                                           <div class="ui star rating " data-rating="{$review[$e]['review']} " data-max-rating="5"></div><span>({$review[$e]['review']})</span>
                                               
                                           </div>
                                       </div>
                                       <div class="text">
                                           {$comment}
                                       </div>
                                   </div>
                               </div>
                           </div>
print;
                            echo $show;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php
        echo $av;
        ?>

    </div>
    <div class="container-fluid mt-5 bg-light">
        <div class="p-2 m-2">
            <div class="row">
                <div class="col">
                </div>
                <div class="col-7">
                    <div class="ui overview">
                        <p class="display-3"><i class="ui edit outline icon violet"></i>Overview</p>
                        <p class="h4"><?php echo $excursion['exc_description'] ?></p>
                    </div>
                    <div class="ui overview mt-5">
                        <p class="display-3"><i class="dropbox icon"></i>What is include</p>
                        <p class="h4"><i class="ui check circle outline icon green"></i>Driver/guide</p>
                        <p class="h4"> <i class="ui check circle outline icon green"></i> Lunch with complimentary wine</p>
                    </div>
                    <div class="ui overview mt-5">
                        <p class="display-3"><i class="ui bus icon green"></i>Departure & Return</p>
                        <p class="h4"><i class="ui check circle outline icon green"></i>Traveler pickup is offered</p>
                        <p class="h4"> <i class="ui check circle outline  icon green"></i> There might be assigned meeting points in walking distance from the accommodation.</p>
                    </div>
                    <div class="ui overview mt-5">
                        <p class="display-3"><i class="ui pencil icon blue"></i>Additional Info</p>
                        <p class="h4"><i class="ui check circle outline  icon green"></i>Confirmation will be received at time of booking</p>
                        <p class="h4"> <i class="ui check circle outline  icon green"></i> Subject to availability</p>
                        <p class="h4"><i class="ui check circle outline  icon green"></i> There is a possibility of cancellation after confirmation if the days of operation change.</p>
                        <p class="h4"> <i class="ui check circle outline  icon green"></i> This tour/activity will have a maximum of <?php ?> travelers</p>

                    </div>
                </div>
                <div class="col ">
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid mt-5 pl-5 pr-5">
        <div class="">
            <div class="ui overview mt-5 text-center">
                <p class="display-3"><i class="credit card outline icon violet"></i>Customers Who Bought This Tour Also Bought</p>
                <?php include_once 'sugestion_tour.php' ?>
                <hr>
                <?php include_once 'popular_event.php' ?>
            </div>
        </div>
    </div>
    <script>
        $('.ui.rating').rating('disable')
    </script>
    </div>
    <div style="height: 10vh"></div>
    <?php include_once('footer.html') ?>
    <script src="../script.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>