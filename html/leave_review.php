<?php
require_once('function.php');
session_start();

if(isset($_REQUEST['submit'])){
    insert_review($_SESSION['user_login']['member_id'],$_REQUEST['select_exc'],$_REQUEST['rating'],$_REQUEST['comment']);
}


$excursion = get_all_excursion();

if (isset($_REQUEST['select_exc'])) {
    $review = get_review($_REQUEST['select_exc']);
    for ($i = 0; $i < count($excursion); $i++) {
        if ($excursion[$i][9] == $_REQUEST['select_exc']) {
            $sng_exc = $excursion[$i];
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

    <script src="../semantic/dist/semantic.min.js"></script>
    <script src="../semantic/dist/semantic.js"></script>
    <script src="../semantic/dist/components/rating.js"></script>
    <script src="../semantic/dist/components/dropdown.js"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anony1mous">

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

<body class="bg-light">
    <?php
    require_once 'login_form.php';
    require_once 'navigation_bar.php';
    ?>
    <div style="height: 10vh"></div>
    <div class="container">
        <p class="display-3 ">Leave review</p>
        <p>Please select Excursion</p>
        <div class="ui selection dropdown w-50 border border-primary">

            <input type="hidden" name="excursion" id="exc_dropdown" value="<?php echo $_REQUEST['select_exc'] ?>">
            <i class="dropdown icon"></i>
            <div class="default text">Excursion</div>
            <div class="menu">
                <?php
                foreach ($excursion as $e) {
                    echo "<div class='item' data-value='{$e[9]}'>{$e[5]}</div>";
                }
                ?>
            </div>
        </div>

        <?php if (isset($_REQUEST['select_exc'])) : ?>
            <div class="ui comments">
                <?php
                // foreach ($review as $r) {
                // }
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
                                   <div class="ui star rating disrating" data-rating="{$e['review']} " data-max-rating="5"></div><span>({$e['review']})</span>
                                       
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

                ?>

                <span class="h4 ">How did you enjoy this Excursion?</span>
                <div id="enrating" class="ui  rating star huge mt-5" data-rating="5" data-max-rating="5"></div>
                <form class="ui reply form" action="leave_review.php" method="GET">
                    <input type="hidden" name="select_exc" value="<?php echo $_REQUEST['select_exc'] ?>">
                    <input type="hidden" name="rating" value="" id="rating">
                    <p class="h4">Please Leave us a comment</p>
                    <div class="field">
                        <textarea name="comment" class="border border-primary" maxlength="2000"></textarea>
                    </div>
                    <button type="submit" name="submit" class="ui primary submit labeled icon button ">
                        <i class="icon edit"></i> Add Comment
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <script>
        $('.ui.dropdown')
            .dropdown();
        $('#enrating')
            .rating({
                initialRating: 0,
                maxRating: 5,
                onRate: function(rating) {
                    $('#rating').val(rating);
                }
            });
        $('.disrating')
            .rating('disable');
        $('#exc_dropdown').change(function() {
            var href = 'leave_review.php?select_exc=' + $('#exc_dropdown').val();
            window.location = href;
        });
    </script>
    <script src="../script.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



</body>

</html>