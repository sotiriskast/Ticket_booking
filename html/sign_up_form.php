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

                    $name = $_POST['first_name'];
                    $surname = $_POST['last_name'];
                    $email = $_POST['email'];
                    $tel = $_POST['tel'];
                    $status = 'Bronze';
                    $passwd = $_POST['passwd'];

                    if (insert_new_member($name, $surname,  $email,  $tel, $status,  $passwd)) {
                        $_SESSION['user_login'] = $login;
                        $login_button = 'Logout';
                        $error_button = '';

                        $cookie_name = "user";
                        $cookie_value = $login['member_name'];
                        setcookie($cookie_name, $cookie_value, time() + (80000) * 60, "/"); //valid for two moths

                        $cookie_name = "email";
                        $cookie_value = $login['member_email'];
                        setcookie($cookie_name, $cookie_value, time() + (86400) * 60, "/"); //valid for two moths

                        $user_account = <<<btn
                        <a class="nav-link " id="user_account" href="#">
                        <i class="cart arrow down icon"></i>
                      {$login['member_name']} Account's
                      </a>
btn;
                        header('Location: homepage.php');
                    } else {
                        $confirm_message = 'Something went wrong please try again later';
                    }
                }
            }
        } else {
            $chk_box_clicked = 'Please accept term and condition';
        }
    }
}
if (isset($_POST['email_ajax'])) {
    if (is_email_exist($_POST['email_ajax']) == false) {
        $response = true;
        return $response;
    } else {
        $response = false;
        return $response;
    }
}
if (isset($_POST['tel_ajax'])) {
    if (is_telephone_exist($_POST['tel_ajax']) == false) {
        $response = true;
        return $response;
    } else {
        $response = false;
        return $response;
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
                                <label for="sign_up_email"><span>&starf;</span>Email <span id="email_result"></span></label>
                                <input id="sign_up_email" type="email" name="email" class="form-control text-form-control" placeholder="Email" value="<?php echo $user_email; ?>" required aria-describedby="emailHelp" pattern="[^@]+@[^\.]+\..+" title="This field is require (ex. example@mail.com)">
                            </div>
                            <div class="col-6">
                                <label for="tel_ajax"><span>&starf;</span>Telephone <span id="tel_result"></span></label>
                                <input id="tel_ajax" type="tel" class="form-control text-form-control" name="tel" maxlength="15" placeholder="Telephone" value="<?php echo $mobile; ?>" required aria-describedby="telephone" pattern="^[0-9]+$">
                            </div>
                        </div>
                        <!-- <div class="flex-box-form">
                            <div class="col-6">
                                <label for="datepicker"> Date of birth</label>
                                <div class="ui right icon ">
                                    <input id="datepicker" type="text" name="dob" class="form-control text-form-control" readonly />
                                </div>
                                <script>
                                    $('#datepicker').datepicker({});
                                </script>
                            </div>
                            <div class="col-6">
                                <label for="country">Country</label>
                                <select class="ui dropdown dropdown-select " name="country" id="country">
                                    <option value="">Select Country</option>
                                    <?php
                                    // add all country
                                    // asort($EU);
                                    // foreach ($EU as $key => $value) {
                                    //     echo "<option>$value</option>";
                                    // }
                                    ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="flex-box-form">
                            <div class="col-6">
                                <label for="passwd"><span>&starf;</span> Password</label>
                                <input id="passwd" type="password" class="form-control text-form-control" name="passwd" required placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                            </div>
                            <div class="col-6">
                                <label for="re_passwd_entry"><span>&starf;</span> re-Password</label>
                                <input id="re_passwd_entry" type="password" class="form-control text-form-control" name="re_passwd" required placeholder="Re entry Password" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="flex-box-form">
                            <div class="col-12">
                                <p></p>
                                <h5>I have read the privacy statement is in compliance with the Personal Data Protection Code and hereby agree that:</h5>
                            </div>
                            <div class="col-12">
                                <div class="ui checkbox">
                                    <input id="policy" required type="checkbox" name="chk_box">
                                    <label for="policy">I acknowledge that I have read and agree to the <a href="#">Privacy Policy </a> <span class="small text-danger "><?php echo $chk_box_clicked ?></span></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <input class="ui blue submit button  w-100" id="submit" type="submit" value="Sign up" name="submit">
                            </div>

                            <div class="col-12">
                                <p><?php
                                    //display result on screen if the message has sended or not
                                    echo $confirm_message; ?>
                                </p>

                            </div>
                            <div id="message">
                                <h3>Password must contain the following:</h3>
                                <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                <p id="number" class="invalid">A <b>number</b></p>
                                <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                            </div>

                            <script>
                                var myInput = document.getElementById("passwd");
                                var letter = document.getElementById("letter");
                                var capital = document.getElementById("capital");
                                var number = document.getElementById("number");
                                var length = document.getElementById("length");

                                var re_entry = document.getElementById("re_passwd");
                                // When the user clicks on the password field, show the message box
                                myInput.onfocus = function() {
                                    document.getElementById("message").style.display = "block";
                                }

                                // When the user clicks outside of the password field, hide the message box
                                myInput.onblur = function() {
                                    document.getElementById("message").style.display = "none";
                                }

                                // When the user starts to type something inside the password field
                                myInput.onkeyup = function() {
                                    // Validate lowercase letters
                                    var lowerCaseLetters = /[a-z]/g;
                                    if (myInput.value.match(lowerCaseLetters)) {
                                        letter.classList.remove("invalid");
                                        letter.classList.add("valid");
                                    } else {
                                        letter.classList.remove("valid");
                                        letter.classList.add("invalid");
                                    }

                                    // Validate capital letters
                                    var upperCaseLetters = /[A-Z]/g;
                                    if (myInput.value.match(upperCaseLetters)) {
                                        capital.classList.remove("invalid");
                                        capital.classList.add("valid");
                                    } else {
                                        capital.classList.remove("valid");
                                        capital.classList.add("invalid");
                                    }

                                    // Validate numbers
                                    var numbers = /[0-9]/g;
                                    if (myInput.value.match(numbers)) {
                                        number.classList.remove("invalid");
                                        number.classList.add("valid");
                                    } else {
                                        number.classList.remove("valid");
                                        number.classList.add("invalid");
                                    }
                                    // Validate length
                                    if (myInput.value.length >= 8) {
                                        length.classList.remove("invalid");
                                        length.classList.add("valid");
                                    } else {
                                        length.classList.remove("valid");
                                        length.classList.add("invalid");
                                    }
                                }
                            </script>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="../script.js"></script>
</body>

</html>