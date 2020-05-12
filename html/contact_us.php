<?php
require_once 'countries.php';
require_once  'function.php';
session_start();

if (isset($_POST['submit'])) {
    if (!is_numeric($_POST['tel']) || is_valid_name($_POST['first_name']) == false || is_valid_name($_POST['last_name']) == false || is_valid_email($_POST['email']) == false) {
        $confirm_message = 'Please enter correct information';
    } else {
        if (isset($_POST['chk_box'])) {
            if (is_email_exist($_POST['email'], $db) == true) {
                $confirm_message = 'Please select different email';
            } else {
                if (is_telephone_exist($_POST['tel']) == true) {
                    $confirm_message = 'Please select different telephone';
                } else {

                    // $name = $_POST['first_name'];
                    // $surname = $_POST['last_name'];
                    // $email = $_POST['email'];
                    // $tel = $_POST['tel'];
                    // $status = 'Bronze';
                    // $passwd = $_POST['passwd'];
                    // Mail SEND
                    $confirm_message = 'Message has send!!';
                }
            }
        } else {
            $chk_box_clicked = 'Please accept term and condition';
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
    <title>Sign up</title>
    <link rel="shortcut icon" href="https://res.cloudinary.com/sotiris/image/upload/v1586768666/Tour_Excursion/logo_f9ozsq.png" type="image/x-icon" />

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="../semantic/dist/semantic.min.css">
    <link rel="stylesheet" href="../semantic/dist/components/dropdown.css">
    <script src="../semantic/dist/semantic.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anony1mous">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sing_up.css">

</head>

<body>
    <?php require_once 'navigation_bar.php'; ?>
    <div style="height: 15vh"></div>

    <div class="ui placeholder segment">
        <div class="ui very relaxed stackable grid">
            <div class="column">
                <div class="container-contact-form w-75 m-auto">
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <div class="flex-box-form">
                            <div class="col-6">
                                <label for="first-name"><span>&starf;</span> First Name</label>
                                <input id="first_name" type="text" class="form-control text-form-control" name="first_name" required placeholder="First name" value="<?php echo $user_f_name; ?>" pattern="^[A-Za-z]+$">
                            </div>
                            <div class="col-6">
                                <label for="last-name"><span>&starf;</span> Last Name</label>
                                <input id="last_name" type="text" class="form-control text-form-control" name="last_name" required placeholder="Last name" value="<?php echo $user_l_name; ?>" aria-describedby="basic-addon1" pattern="^[A-Za-z]+$">
                            </div>
                        </div>
                        <div class="flex-box-form">
                            <div class="col-6">
                                <label for="sign_up_email"><span>&starf;</span>Email </label>
                                <input id="sign_up_email" type="email" name="email" class="form-control text-form-control" placeholder="Email" value="<?php echo $user_email; ?>" required aria-describedby="emailHelp" pattern="[^@]+@[^\.]+\..+" title="This field is require (ex. example@mail.com)">
                            </div>
                            <div class="col-6">
                                <label for="tel_ajax"><span>&starf;</span>Telephone </label>
                                <input id="tel_ajax" type="tel" class="form-control text-form-control" name="tel" maxlength="15" placeholder="Telephone" value="<?php echo $mobile; ?>" required aria-describedby="telephone" pattern="^[0-9]+$">
                            </div>
                        </div>
                        <div class="flex-box-form">
                            <div class="col-12">
                                <label for="msg"><span>&starf;</span>Message</label>
                                <textarea name="msg" id="msg" class="mw-100" placeholder="Enter your message here" minlength="15" cols="50" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="flex-box-form">
                            <div class="col-12">
                                <p></p>
                                <h5>I have read the privacy statement is in compliance with the Personal Data Protection Code and hereby agree that:</h5>
                            </div>
                            <div class="col-12">
                                <div class="ui checkbox">
                                    <input id="policy" class="ui blue" required type="checkbox" name="chk_box">
                                    <label for="policy">I acknowledge that I have read and agree to the <a href="#">Privacy Policy </a> <span class="small text-danger "><?php echo $chk_box_clicked ?></span></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <input class="ui blue submit button  w-100" id="submit" type="submit" value="Send Message" name="submit">
                            </div>

                            <div class="col-12">
                                <p class="h4"><?php
                                                //display result on screen if the message has sended or not
                                                echo $confirm_message; ?>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="../script.js"></script>
</body>

</html>