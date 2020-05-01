<?php
$wish_heart_nav = 'outline';
if (isset($_SESSION['user_login'])) {
    $login_button = 'Logout';
    $user_account = <<<btn
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown user_account" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="cart arrow down icon"></i>
    {$_SESSION['user_login']['member_name']} Account's    
  </a>
<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="my_order.php">My Order</a>
    <a class="dropdown-item" href="history.php">History</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="leave_review.php">Leave review</a>
</div>
</li>
btn;
} else {
    $login_button = 'Log in';
}

if (isset($_GET['user_logout']) && $_GET['user_logout'] == 'true') {
    $login_button = 'Log in';
    $user_account = '';
    unset($_SESSION['user_login']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['login_email'];
        $passwd = $_POST['login_passwd'];

        if (is_email_exist($email)) {
            $login = get_member_by_email($email);
            if (password_verify($passwd, $login['member_passwd'])) {
                $_SESSION['user_login'] = $login;
                $login_button = 'Logout';
                $error_button = '';

                $cookie_name = "user";
                $cookie_value = $login['member_name'];
                setcookie($cookie_name, $cookie_value, time() + (86400) * 60, "/"); //valid for two moths

                $cookie_name = "email";
                $cookie_value = $login['member_email'];
                setcookie($cookie_name, $cookie_value, time() + (86400) * 60, "/"); //valid for two moths

                $user_account = <<<btn
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown user_account" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="cart arrow down icon"></i>
                {$_SESSION['user_login']['member_name']} Account's    
              </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="my_order.php">My Order</a>
            <a class="dropdown-item" href="history.php">History</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="leave_review.php">Leave review</a>
            </div>
            </li>

btn;




                // echo json_encode(array(
                //     "success" => $result

                // ));
            } else {
                $error_button = ' text-danger';
                // echo json_encode(array(
                //     "success" => $result,
                //     "message" => $errors,
                // ));

            }
        } else {
            $error_button = ' text-danger';
            // echo json_encode(array(
            //     "success" => $result,
            //     "message" => $errors,
            // ));

        }
    }
}


if (isset($_COOKIE)) {
    $_SESSION['username'] = $_COOKIE['user'];
    $_SESSION['email'] = $_COOKIE['email'];
}
?>

<?php
//print when the user is logout
if (!isset($_SESSION['user_login'])) :
?>
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="user icon"></i><?php $p = (isset($_SESSION['username'])) ?  "Welcome back {$_SESSION['username']}" :  "Sign in";
                                                                                            echo $p ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="ui placeholder segment">
                        <div class="ui two column very relaxed stackable grid">
                            <div class="column">
                                <form class="ui form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                                    <div class="field">
                                        <label>Email</label>
                                        <div class="ui left icon input">
                                            <input name="login_email" type="text" id="email" placeholder="email" value="<?php echo $_SESSION['email'] ?>">
                                            <i class="user icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>Password</label>
                                        <div class="ui left icon input">
                                            <input name="login_passwd" type="password" id="paswwd" placeholder="Password">
                                            <i class="lock icon"></i>
                                        </div>
                                    </div>
                                    <input id="user_login" class="ui blue submit button w-100" type="submit" value="Login" name="login">
                                </form>
                            </div>
                            <div class="middle aligned column">
                                <a class="ui big button" href="sign_up_form.php">
                                    <i class="signup icon"></i>
                                    Sign Up
                                </a>
                            </div>
                        </div>
                        <div class="ui vertical divider">
                            Or
                        </div>
                    </div>
                </div>
                <a class="ui small button" href="#">
                    <i class="forgot icon"></i>
                    Forgot password
                </a>
            </div>
        </div>
    </div>
<?php endif ?>