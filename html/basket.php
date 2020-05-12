<?php
require_once('function.php');
session_start();
if (isset($_REQUEST['remove'])) {
    $arr = json_decode($_COOKIE['basket']);
    $i = 0;
    foreach ($arr as $e) {

        if (!($e[0] == $_REQUEST['title'] && $e[1] == $_REQUEST['date'] && $e[2] == $_REQUEST['starting'] && $e[6] == $_SESSION['user_login']['member_id'] && $i == 0)) {
            $arr1[] = $e;
        } else {
            $i++;
        }
    }
    unset($arr);
    $cookie_name = 'basket';
    $cookie_value =  $arr1;
    setcookie($cookie_name, json_encode($cookie_value), time() + (86400) * 60, "/"); //valid for two moths 
    header('Location: basket.php');
    die();
}

$arr = json_decode($_COOKIE['basket']);
foreach ($arr as $a) {
    if ($a[6] == $_SESSION['user_login']['member_id']) {
        $img = get_images($a[0]);
        $availability[] = array('ave' => dispaly_availability($a[0], $a[1], $a[2]), 'adls' => $a[3], 'kids' => $a[4], 'infants' => $a[5], 'img' => $img[0][0]);
    }
}


if (!empty($availability)) {
    foreach ($availability as $e) {
        $total_guest = $e['adls'] +  $e['kids'] +  $e['infants'];
        $adults = $e['ave'][0]['tour_price'] * $e['adls'];
        $kids = (100 - $e['ave'][0]['tour_price_kids']) / 100 * $e['ave'][0]['tour_price'] * $e['kids'];
        $price = $adults + $kids;
        $total_price += $price;
        $count = count_booking($e['ave'][0]['tour_id'], $e['ave'][0]['tour_date']);
        if ($e['ave'][0]['exc_availability'] - $count[0][0] > $total_guest) {

            $av .= <<<print
  <hr>
<div class="ui icon message mt-3">
<div class="img-fluid w-25 h-25">
<img src="{$e['img']}" width="100%" height="100%" alt="">
</div>
<div class="content w-25">
<div class="header pl-3">
  <p>{$e['ave'][0]['exc_title']}</p>
</div>
<div class="pl-3">
  <p >Starting:point: <i class="text-primary"> {$e['ave'][0]['tour_starting_point']}</i></p>
  <p>Date {$e['ave'][0]['tour_date']}</p>
  <p>Time: {$e['ave'][0]['tour_time_start']}</p>
  <p>Booked: {$count[0][0]} out of {$e['ave'][0]['exc_availability']}</p>
  <p>Guide: {$e['ave'][0]['gd_name']} {$e['ave'][0]['gd_surname']}</p>
</div>
</div>
<div class="content ">
<div class="ui large  transparent left icon">
  <div class="m-auto w-50">
      <p>Total: <i class="euro icon"></i>{$price}</p>
      <p><a href="basket.php?remove=true&title={$e['ave'][0]['exc_id']}&date={$e['ave'][0]['tour_date']}&total_guest={$total_guest}&starting={$e['ave'][0]['tour_starting_point']}"  class="ui pink button">Remove </a></p>
      <p class="ui small p-0 m-0"><i class="time outline icon"></i>Duration: {$e['ave'][0]['exc_duration']}</p>
      <p class="ui small p-0 m-0"><i class="time outline icon"></i>Adults: {$e['adls']}, Kids: {$e['kids']}, Infants: {$e['infants']}</p>
</div>
</div>
</div>
</div>
print;

            if (isset($_REQUEST['book'])) {
                $resv_id = random_resv_id();
                insert_new_reservation($resv_id, $_SESSION['user_login']['member_id'], $e['ave'][0]['exc_id'], $e['ave'][0]['tour_date'],  $price);
                insert_new_participant($resv_id, 'Adults', $e['adls']);
                insert_new_participant($resv_id, 'Kids', $e['kids']);
                insert_new_participant($resv_id, 'Infants', $e['infants']);
                update_count_booking($e['ave'][0]['exc_id']);
            }
        }
    }
}
if (isset($_REQUEST['book'])) {
    $arr = json_decode($_COOKIE['basket']);

    foreach ($arr as $e) {

        if ($e[6] != $_SESSION['user_login']['member_id']) {
            $arr1[] = $e;
        }
    }
    unset($arr);
    $cookie_name = 'basket';
    $cookie_value =  $arr1;
    setcookie($cookie_name, json_encode($cookie_value), time() + (86400) * 60, "/"); //valid for two moths 
    header('Location: my_order.php');
    die();
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
        <?php if ($availability != null) : ?>
            <?php echo $av; ?>
            <div class="row">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col">
                    <table class="m-auto">
                        <tbody>
                            <tr>
                                <td>Cost: </td>
                                <td><i class="ui euro icon"></i><?php echo number_format($total_price * .81, 2) ?></td>
                            </tr>
                            <tr>
                                <td>VAT: 19 &percnt;: </td>
                                <td><i class="ui euro icon"></i><?php echo number_format($total_price * .19, 2) ?></td>
                            </tr>
                            <tr>
                                <td>Total Price: </td>
                                <td><i class="ui euro icon"></i><?php echo number_format($total_price, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="basket.php?book=true" class="ui button violet w-100 mt-2">BOOK</a>
                </div>
            </div>
        <?php else : ?>
            <section class="ui overview bg-light p-5">
                <div class="ui content-overview  p-5 m-auto text-center">
                    <h1>Basket</h1>
                    <p>Your Basket is empty</p>
                    <p><a class="btn-link" href="tour_list.php">Click here to go to Tour List page</a></p>
                    <p></p>
                </div>
            </section>
        <?php endif; ?>
        <hr>
    </div>
    <script src="../script.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>