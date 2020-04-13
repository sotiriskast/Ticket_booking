<?php
require_once 'countries.php';
require_once  'function.php';
require_once  '../connect_dbase.php';

if (isset($_POST['submit'])) {
    if (isset($_REQUEST['country']) || is_numeric($_REQUEST['tel']) || is_valid_name($_REQUEST['first_name']) == false || is_valid_name($_REQUEST['last_name']) == false || is_valid_email($_REQUEST['email'])) {
        $error = 'Please enter correct information';
    } else {
        if (isset($_REQUEST['chk_box'])) {
            // $query = 'INSERT INTO Member() 
            // VALUES(:title, :link)';
            // $prep = $db->prepare();
            // $prep->execute();
        }
    }
}

// $hash= password_hash("sotiris", PASSWORD_BCRYPT)."\n";
// var_dump($hash);


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
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" name="contact_form">
                        <div class="flex-box-form">
                            <div class="col-6">
                                <label for="first-name"><span>&starf;</span> First Name</label>
                                <input id="first_name" type="text" class="form-control text-form-control" name="first_name" required placeholder="First name" value="<?php echo $user_f_name; ?>"  pattern="^[A-Za-z]+$">
                            </div>
                            <div class="col-6">
                                <label for="last-name"><span>&starf;</span> Last Name</label>
                                <input id="last_name" type="text" class="form-control text-form-control" name="last_name" required placeholder="Last name" value="<?php echo $user_l_name; ?>" aria-describedby="basic-addon1" pattern="^[A-Za-z]+$">
                            </div>
                        </div>
                        <div class="flex-box-form">
                            <div class="col-6">
                                <label for="email"><span>&starf;</span>Email</label>
                                <input id="email" type="email" class="form-control text-form-control" name="email" placeholder="Email" value="<?php echo $user_email; ?>" required aria-describedby="emailHelp" pattern="[^@]+@[^\.]+\..+">
                            </div>
                            <div class="col-6">
                                <label for="tel"><span>&starf;</span>Telephone</label>
                                <input id="tel" type="tel" class="form-control text-form-control" name="tel" placeholder="Telephone" value="<?php echo $mobile; ?>" required aria-describedby="telephone" pattern="^[0-9]+$">
                            </div>
                        </div>
                        <div class="flex-box-form">
                            <div class="col-6">
                                <label for="dob"> Date of birth</label>
                                <div class="ui right icon ">
                                    <input id="datepicker" class="form-control text-form-control" type="text" />
                                </div>
                                <script>
                                    $('#datepicker').datepicker({});
                                </script>
                            </div>
                            <div class="col-6">
                                <label for="country"><span>&starf;</span> Country</label>
                                <select class="ui dropdown dropdown-select " name="country" id="country" required>
                                    <option value="">Select Country</option>
                                    <?php
                                    // add all country
                                    asort($EU);
                                    foreach ($EU as $key => $value) {
                                        echo "<option>$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex-box-form">
                            <div class="col-6">
                                <label for="first-name"><span>&starf;</span> Password</label>
                                <input type="password" class="form-control text-form-control" name="passwd" required placeholder="Password" id="passwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                            </div>
                            <div class="col-6">
                                <label for="last-name"><span>&starf;</span> re-Password</label>
                                <input type="password" class="form-control text-form-control" name="re_passwd" required placeholder="re_passwd" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="flex-box-form">
                            <div class="col-12">
                                <h2>Data Privacy &amp; Term &amp; Condition</h2>
                                <h5>I have read the privacy statement is in compliance with the Personal Data Protection Code and hereby agree that:</h5>
                            </div>
                            <div class="col-12">
                                <div class="ui checkbox">
                                    <input id="policy" required type="checkbox" name="chk_box">
                                    <label for="policy">I acknowledge that I have read and agree to the <a href="#">Privacy Policy</a></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <input class="ui blue submit button  w-100" id="psw" type="submit" value="Sign up" name="submit">
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
                </div>
                </form>
                <div class="flex-box-form">
                    <div class="col-12">
                        <p><?php
                            //display result on screen if the message has sended or not
                            echo $confirm_message; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




</body>

</html>