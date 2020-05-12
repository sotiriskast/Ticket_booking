<?php
require_once('function.php');
session_start();


if (isset($_REQUEST['cancel'])) {
    cancel_reservation($_REQUEST['resv_id']);
    update_count_booking($_REQUEST['exc_id'], 'MINUS');
}


$order = get_member_order($_SESSION['user_login']['member_id']);
foreach ($order as $e) {
    if ($e['resv']['resv_id'] == $_REQUEST['resv_id']) {
        $print = $e;
    }
}

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
      <p><a target="_blank" href="my_order.php?get_ticket=true&resv_id={$e['resv']['resv_id']}&exc_id={$e['resv']['exc_id']}" class="ui blue button w-100">Get Ticket </a></p>
      <p><a data-href="my_order.php?cancel=true&resv_id={$e['resv']['resv_id']}&exc_id={$e['resv']['exc_id']}" class="ui red button cancel w-100">Cancel </a></p>
      <p class="ui small p-0 m-0"><i class="time outline icon"></i>Duration: {$e['resv']['exc_duration']}</p>
      <p class="ui small p-0 m-0">Adults: {$e['par'][0][2]}, Kids: {$e['par'][1][2]}, Infants: {$e['par'][2][2]}</p>
</div>
</div>
</div>
</div>
print;
    }
}
if (isset($_REQUEST['get_ticket'])) {
    require('../TCPDF/tcpdf.php');


    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    // $pdf->SetAuthor('Nicola Asuni');
    // $pdf->SetTitle('TCPDF Example 001');
    // $pdf->SetSubject('TCPDF Tutorial');
    // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
    $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

    // set header and footer fonts
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 14, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    // set text shadow effect
    $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.1, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

    // include 2D barcode class (search for installation path)
    $matr = 'https://barcode.tec-it.com/barcode.ashx?data=http%3A%2F%2Flocalhost%3A3000%2Fhtml%2Fmy_order.php&code=DataMatrix&multiplebarcodes=true&translate-esc=false&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=&qunit=Mm&quiet=0&dmsize=Default';
    $html = <<<EOD
<div><img src="{$print['img'][0]}"></div>
<p >Full Name: <i>{$print['resv']['member_name']} {$print['resv']['member_name']}</i></p>
<p>Booking Date: <i style="color:blue">{$print['resv']['resv_date']}</i> Time: <i style="color:blue">{$print['resv']['tour_time_start']}</i></p>

<ul>
<li>Adults: {$print['par'][0][2]}</li>
<li>Kids: {$print['par'][1][2]}</li>
<li>Infants {$print['par'][2][2]}</li>
</ul>
<p>Starting Point: <i style="color:blue">{$print['resv']['tour_starting_point']}</i> Duration: <i style="color:blue">{$print['resv']['exc_duration']}</i></p>
<p>{$bar}</p>
<p>Total Price: <i style="color:blue">{$print['resv']['resv_price']} EUR</i></p>
<div style="text-align:center">
<img src="{$matr}" alt="" srcset="">
</div>


EOD;

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    // ---------------------------------------------------------

    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('example_001.pdf', 'I');

    //============================================================+
    // END OF FILE
    //============================================================+

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
        <p class="display-3 ">Your Order</p>
        <?php if (!empty($av)) : ?>
            <?php echo $av ?>
        <?php else : ?>
            <section class="ui overview bg-light p-5">
                <div class="ui content-overview  p-5 m-auto text-center">
                    <h1>Order</h1>
                    <p>Nothing book yet</p>
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