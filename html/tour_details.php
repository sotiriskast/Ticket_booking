<?php
session_start();
require_once 'function.php';

if (isset($_REQUEST['title'])) {
    $image = get_images($_REQUEST['title']);
    $excursion = get_single_excursion($_REQUEST['title']);
    $tour = get_tour_excursion($_REQUEST['title']);
    $review = get_review($_REQUEST['title']);
}

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

<body>
    <?php
    require_once 'login_form.php';
    require_once 'navigation_bar.php';

    ?>
    <div style="height: 15vh"></div>
    <div class="ui warning message container corona-virus p-4">
        <i class="close icon"></i>
        <div class="header">
            <i class="info circle icon red"></i>
            To limit the spread of the coronavirus, attractions may be closed or have partial closures. Please consult government travel advisories before booking.
            The WHO is closely monitoring the coronavirus and more information can be found <a class="ui " href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019">here</a>
        </div>
    </div>
    <script>
        $('.corona-virus').on('click', function() {
            $('.corona-virus').remove();
        });
    </script>

    <!-- <div class="ui breadcrumb">
        <a class="section" href="homepage.php">Home</a>
        <i class="right chevron icon divider"></i>
        <a class="section" href="tour_list.php">Tour List</a>
        <i class="right arrow icon divider"></i>
        <div class="active section">Tour Information</div>
    </div> -->
    <div class="container pb-0 mb-0">
        <div class="row pb-0 mb-0">
            <div class="col pl-5">
                <p class="h1"><?php echo $excursion['exc_title']; ?></p>
            </div>
        </div>
        <div class="row pb-0 mb-0">
            <div class="col pl-5">
                <div class="ui star rating" data-rating="<?php echo round($excursion['average']); ?>" data-max-rating="5"></div><span>( <?php echo round($excursion['average'], 2); ?> ) <a class="btn-link " href="#review"> Total review ( <?php echo round($excursion['total_count'], 0); ?> )</a></span>
            </div>
            <div class="col text-right pr-5">
            <a class="btn-link " href="#review"><i class="ui heart outline icon red"></i>Add to Wash list</a>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-0 mt-0">
        <div class="p-2 m-2">
            <div class="row">
                <div class="col bg-light">
                    <form action="tour_details.php" method="GET">
                        <p class="h2"> Price From: <i class="ui euro icon"></i><?php echo $tour[0]['tour_price'] ?></p>
                        <p class="h4">Starting point: <?php echo $tour[0]['tour_starting_point'] ?></p>
                        <div class="ui">
                            <label for="datepicker"> Selectet Day</label>
                            <div class="ui right icon w-100">
                                <input id="datepicker" type="text" name="datapicker" class="form-control text-form-control" readonly />
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
                            </select>
                        </div>


                        <div class="ui">
                            <label for="kids"><span>&starf;</span> Kids (2-12)</label>
                            <select name="kids" id="kids" class="dropdown-select kids" style="width: 100%" required>
                                <option selected value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option disabled value="3">3</option>
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
                            $('#datepicker').datepicker({});
                        </script>
                        <input type="hidden" name="title" value="<?php echo $_REQUEST['title'] ?>">
                        <input class="mt-3 w-100 btn input bg-primary p-2 text-white" type="submit" value="Check Availability" name="submit">
                    </form>
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
                                $comment = 'Nothing post';
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
            </div>
        </div>
    </div>
    <script>
        $('.ui.rating').rating('disable')
    </script>
    </div>
    <div style="height: 100vh"></div>
    <script src="../script.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>