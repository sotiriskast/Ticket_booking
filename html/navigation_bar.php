<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top ">
    <a class="navbar-brand img-logo" href="../html/homepage.php"><img src="https://res.cloudinary.com/sotiris/image/upload/v1586768666/Tour_Excursion/logo_f9ozsq.png" width="100%" height="100%" alt="" srcset=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto " style="font-size: 1.2rem; font-weight: 500;">
            <li class="nav-item ">
                <a class="nav-link" href="../html/homepage.php">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Tour List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Aboout us</a>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact us</a>
            </li>
        </ul>
        <div class="navbar-nav">
            <?php echo $user_account; ?>

            <a class="nav-link " href="#">
                <i class="cart arrow down icon"></i>
                Basket
            </a>

            <a class="nav-link" href="#">
                <i class=" heart outline icon"></i>
                Favorite
            </a>
            <a class="nav-link <?php echo $error_button; ?> logout" data-toggle="modal" data-target="#login" style="cursor: pointer">
                <i class=" user circle outline icon"></i><?php echo $login_button; ?>
            </a>

        </div>
    </div>
</nav>
