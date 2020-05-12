<?php
require_once('function.php');
session_start();

$order = get_member_history($_SESSION['user_login']['member_id']);
if (!empty($order)) {
    foreach ($order as $e) {
        $total_guest = $e['par'][0][2] +  $e['par'][1][2] +  $e['par'][2][2];
        $price = $e['resv']['resv_price'];
        $av .= <<<print
  <hr>
<div class="ui icon message mt-3">
<div class="img-fluid w-25 h-25">
<img src="{$e['img'][0]}" width="100%" height="100%" alt="">
</div>
<div class="content w-25">
<div class="header pl-3">
  <p>{$e['resv']['exc_title']}</p>
</div>
<div class="pl-3">
  <p >Starting:point: <i class="text-primary"> {$e['resv']['tour_starting_point']}</i></p>
  <p>Date {$e['resv']['resv_date']}</p>
  <p>Time: {$e['resv']['tour_time_start']}</p>
</div>
</div>
<div class="content ">
<div class="ui large  transparent left icon">
  <div class="m-auto w-50">
      <p>Total: <i class="euro icon"></i>{$price}</p>
      <p class="ui olive header">{$e['resv']['resv_status']}</p>
      <p class="ui small p-0 m-0"><i class="time outline icon"></i>Duration: {$e['resv']['exc_duration']}</p>
      <p class="ui small p-0 m-0">Adults: {$e['par'][0][2]}, Kids: {$e['par'][1][2]}, Infants: {$e['par'][2][2]}</p>
</div>
</div>
</div>
</div>
print;
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

<body>
    <?php
    require_once 'login_form.php';
    require_once 'navigation_bar.php';
    ?>
    <div style="height: 10vh"></div>
    <div class="container">
        <p class="display-3 ">History</p>
        <?php if (!empty($av)) : ?>
            <?php echo $av ?>
        <?php else : ?>
            <section class="ui overview bg-light p-5">
                <div class="ui content-overview  p-5 m-auto text-center">
                    <h1>History</h1>
                    <p>Nothing  yet</p>
                    <p><a class="btn-link" href="tour_list.php">Click here to go to Tour List page</a></p>
                    <p></p>
                </div>
            </section>
        <?php endif; ?>
    </div>

    <script src="../script.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>