<?php

try {
    // create a new PDO object
    $dsn = 'mysql:host=localhost;dbname=1517_TOURS_AND_EXCURSION';
    $username = 'username';
    $password ='password';
    //creates PDO object
    $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
    // redirect to 'error.php'. Pass the error message to 'error.php'
    // using GET i.e. error.php?error=message
    $str = $e->getMessage();
    header("Location: error.php?error=$str");
    die();
    // the error message can be found in $e->getMessage()
}


