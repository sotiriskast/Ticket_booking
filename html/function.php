<?php
//login user into their account
require_once  '../connect_dbase.php';

//validation
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//check the name
function is_valid_name($name)
{
  if (empty($name)) {
    return false;
  } else {

    // check if name only contains letters and whitespace
    if (ctype_alpha($name)) {
      return true;
    }
    return false;
  }
}

//validate email
function is_valid_email($email)
{
  if (empty($email)) {
    return false;
  } else {
    $email = test_input($email);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
    }
    return true;
  }
}

function is_email_exist($email)
{
  global $db;
  $query = 'SELECT member_email, member_passwd,member_name
              FROM Member WHERE member_email=?';
  $log = $db->prepare($query);
  $log->bindValue(1, $email);
  $log->execute();
  $login = $log->fetch();
  $log->closeCursor();
  if ($login == null) {
    return  false;
  } else {
    return false;
  }
}

function is_telephone_exist($tel)
{
  global $db;
  $query = 'SELECT member_email, member_passwd,member_name,member_tel
              FROM Member WHERE member_tel=?';
  $log = $db->prepare($query);
  $log->bindValue(1, $tel);
  $log->execute();
  $login = $log->fetch();
  $log->closeCursor();
  if ($login == null) {
    return  false;
  } else {
    return false;
  }
}




function random_member_id()
{
  global $db;
  $c = range('A', 'Z');
  $s = range('a', 'z');
  $n = range('0', '9');
  $mrg = array_merge($c, $n, $s);
  shuffle($mrg);
  shuffle($mrg);
  for ($i = 0; $i < 8; $i++) {
    $id .= $mrg[$i];
  }

  $query = 'SELECT member_id FROM Member WHERE member_id=:id';
  $mb_id = $db->prepare($query);
  $mb_id->bindValue(':id', $id);
  $mb_id->execute();
  $chk = $mb_id->fetch();
  $mb_id->closeCursor();

  if ($chk == null) {
    //use recursive if is exist to call again the method
    return random_member_id();
  } else {
    return $id;
  }
}

function insert_new_member($name, $surname, $email, $tel,  $status, $passwd)
{
  $hash = password_hash($passwd, PASSWORD_BCRYPT);



  global $db;
  $id = random_member_id();
  $since = new DateTime();
  $since = $since->format('Y/m/d');
  $query = 'INSERT INTO Member() 
            VALUES(?,?,?,?,?,?,?,?)';

  try {


    $prep = $db->prepare($query);
    $prep->bindValue(1, $id);
    $prep->bindValue(2, $name);
    $prep->bindValue(3, $surname);
    $prep->bindValue(4, $email);
    $prep->bindValue(5, $tel);
    $prep->bindValue(6, $status);
    $prep->bindValue(7, $hash);
    $prep->bindValue(8, $since);
    $row_count = $prep->execute();
    $prep->closeCursor();

    return $row_count;
  } catch (PDOException $e) {
    $error = $e->getMessage();
  }
}
