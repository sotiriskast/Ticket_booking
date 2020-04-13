<?php
if (isset($_SESSION['user_login'])) {
    $login_button = 'Logout';
    $user_account = <<<btn
    <a class="nav-link " id="user_account" href="#">
    <i class="cart arrow down icon"></i>
    {$login['member_name']} Account's
    </a>
btn;
} else {
    $login_button = 'Log in';
}

if (isset($_GET['user_logout']) && $_GET['user_logout'] == 'true') {
    $login_button = 'Log in';
    $user_account = '';
    unset($_POST['login']);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['login_email'];
        $passwd = $_POST['login_passwd'];
        $query = 'SELECT member_email, member_passwd,member_name
              FROM Member WHERE member_email=?';
        $log = $db->prepare($query);
        $log->execute(array($email));
        if ($log->rowCount() == 1) {
            $login = $log->fetch();
            if (password_verify($passwd, $login['member_passwd'])) {
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
                // echo json_encode(array(
                //     "success" => $result

                // ));
            } else {
                $error_button = 'btn-danger';
                // echo json_encode(array(
                //     "success" => $result,
                //     "message" => $errors,
                // ));
            }
        }
    }
}


if (isset($_COOKIE[$cookie_name])) {
    $_SESSION['username'] = $_COOKIE['user'];
    $_SESSION['email'] = $_COOKIE['email'];
}
?>

<?php
//print when the user is logout
if (empty($_SESSION['user_login'])) :
?>

    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="user icon"></i><?php $p = (isset($_COOKIE['user'])) ?  "Welcome back {$_COOKIE['user']}" :  "Sign in";
                                                                                            echo $f ?> </h5>
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
                                            <input name="login_email" type="text" id="email" placeholder="email" value="<?php $_SESSION['email'] ?>">
                                            <i class="user icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>Password</label>
                                        <div class="ui left icon input">
                                            <input name="login_passwd" type="password" id="paswwd">
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

            </div>
        </div>
    </div>
<?php endif ?>