<?php
require_once('function.php');
session_start();

if (isset($_REQUEST['submit'])) {
    insert_review($_SESSION['user_login']['member_id'], $_REQUEST['select_exc'], $_REQUEST['rating'], $_REQUEST['comment']);
}


$excursion = get_all_excursion();

if (isset($_REQUEST['rate_plan'])) {
    $id = $_REQUEST['excursion'];
    $from = new DateTime($_REQUEST['date_from']);
    $to = new DateTime($_REQUEST['date_to']);
    $price = $_REQUEST['price'];
    $kids = $_REQUEST['kids_price'];
    $tour_id=get_all_tour_excursion_id($id);
    $interval = $from->diff($to)->format('%a');
    $begin = date('Y-m-d', strtotime($_REQUEST['date_from']));
  
    for ($i = 0; $i <= $interval; $i++) {
       
        foreach($tour_id as $e){
            
            insert_tour_date($e['tour_id'], $begin, $price, $kids);

        }
        $repeat = strtotime("+1 day", strtotime($begin));
        $begin = date('Y-m-d', $repeat);
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
    <link rel="stylesheet" href="../semantic/dist/components/dropdown.css">
    <script src="../semantic/dist/components/dropdown.js"></script>
    <script src="../semantic/dist/semantic.min.js"></script>



    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anony1mous">

    <link rel="stylesheet" href="../css/style.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>

    <link rel="stylesheet" href="/CSS/style.css">

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
        <p class="display-3 ">Insert Rate Plan</p>

    </div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
        <fieldset class="p-3">

            <span class="text-danger"><?php echo $error ?></span>
            <div class="row">
                <div class="col">
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
                </div>
                <div class="col">
                    <div class="ui calendar " id="date_calendar1">
                        <p>Date from</p>
                        <div class="ui input left icon border border-primary">
                            <i class="calendar icon"></i>
                            <input type="text" placeholder="Date From" name="date_from" required>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="ui calendar " id="date_calendar_to1">
                        <p>Date to</p>
                        <div class="ui input left icon border border-primary">
                            <i class="calendar icon"></i>
                            <input type="text" placeholder="Date To" name="date_to" required>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col">
                    <p>Price</p>
                    <div class="ui input focus">
                        <input type="text" placeholder="Price" name="price" value="25" required>
                    </div>
                </div>
                <div class="col">
                    <p>Selected Price for <b>Kids by %</b></p>
                    <div class="ui input focus">
                        <input type="text" placeholder="Price" name="kids_price" value="50" required>
                    </div>
                </div>
                <div class="col">
                    <P>Insert</P>
                    <button class="ui primary   button click_submit" type="submit" name="rate_plan">Insert</button>
                    <span class="press"></span>
                </div>
            </div>
            <hr>
        </fieldset>
    </form>
    <script>
        $('.ui.dropdown')
            .dropdown();
        $('.click_submit').click(function() {
            $('.press').append('<i class="ui small active inline loader"></i>');
        });
        $('.ui.dropdown')
            .dropdown();
        $('#date_calendar1')
            .calendar({
                type: 'date',
                endCalendar: $('#date_calendar_to1'),
            });
        $('#date_calendar_to1')
            .calendar({
                type: 'date',
                startCalendar: $('#date_calendar1'),
            });
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>