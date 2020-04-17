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
function get_member_by_email($email)
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
    return $login;
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
    return true;
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

function recent_event()
{
  $today = (new DateTime())->add(new DateInterval("P1D"))->format("Y/m/d");
  global $db;
  $query = 'SELECT  *
            FROM Tour_date
            WHERE tour_date >=?
            ORDER BY tour_date ,tour_id LIMIT 4';

  $rce = $db->prepare($query);
  $rce->bindValue(1, $today);
  $rce->execute();
  $recent = $rce->fetchAll();
  $rce->closeCursor();

  $query = 'SELECT * FROM Tour_excursion
            WHERE tour_id IN(?,?,?,?,?)';

  $prep = $db->prepare($query);

  $prep->bindValue(1, $recent[0]['tour_id']);
  $prep->bindValue(2, $recent[1]['tour_id']);
  $prep->bindValue(3, $recent[2]['tour_id']);
  $prep->bindValue(4, $recent[3]['tour_id']);
  $prep->bindValue(5, $recent[4]['tour_id']);
  $prep->execute();
  $tour = $prep->fetchAll();
  $prep->closeCursor();


  $query = 'SELECT Excursion_image.img_name,exc_id
            FROM Excursion_image 
            WHERE exc_id=?';
  $img = $db->prepare($query);
  foreach ($tour as $t) {
    $img->bindValue(1, $t['exc_id']);
    $img->execute();
    $images[] = $img->fetch();
  }
  $img->closeCursor();
  $query = 'SELECT exc_title
          FROM   Excursion
          WHERE  Excursion.exc_id =?';

  $exc = $db->prepare($query);
  foreach ($tour as $t) {
    $exc->bindValue(1, $t['exc_id']);
    $exc->execute();
    $name_exc[] = $exc->fetch();
  }
  $exc->closeCursor();
  for ($i = 0; $i < 4; $i++) {
    $arr[$i] = array($recent[$i]['tour_date'], $recent[$i]['tour_price'], $tour[$i]['tour_starting_point'], $tour[$i]['tour_time_start'], $images[$i]['img_name'], $name_exc[$i]['exc_title']);
  }


  return   $arr;
}
function popular_event()
{
  global $db;
  $query = 'SELECT exc_title,exc_id
            FROM Excursion 
            ORDER BY exc_count_booking DESC
            LIMIT 4 ';
  $exc = $db->prepare($query);
  $exc->execute();
  $excursion = $exc->fetchAll();
  $exc->closeCursor();

  $query = 'SELECT *
  FROM   Tour_excursion
  WHERE  Tour_excursion.exc_id =?';

  $tr = $db->prepare($query);
  foreach ($excursion as $t) {
    $tr->bindValue(1, $t['exc_id']);
    $tr->execute();
    $tour[] = $tr->fetch();
  }
  $tr->closeCursor();

  $today = (new DateTime())->add(new DateInterval("P1D"))->format("Y/m/d");
  $query = 'SELECT  *
            FROM Tour_date
            WHERE tour_date >=? AND tour_id=?';

  $rce = $db->prepare($query);
  foreach ($tour as $t) {
    $rce->bindValue(1, $today);
    $rce->bindValue(2, $t['tour_id']);
    $rce->execute();
    $tour_date[] = $rce->fetch();
  }
  $rce->closeCursor();

  $query = 'SELECT Excursion_image.img_name,exc_id
            FROM Excursion_image 
            WHERE exc_id=?';
  $img = $db->prepare($query);
  foreach ($excursion as $t) {
    $img->bindValue(1, $t['exc_id']);
    $img->execute();
    $images[] = $img->fetch();
  }
  $img->closeCursor();
  for ($i = 0; $i < 4; $i++) {
    $arr[$i] = array($tour_date[$i]['tour_date'], $tour_date[$i]['tour_price'], $tour[$i]['tour_starting_point'], $tour[$i]['tour_time_start'], $images[$i]['img_name'], $excursion[$i]['exc_title'], $excursion[$i]['exc_id']);
  }


  return   $arr;
}

function get_all_excursion($sort = null)
{
  global $db;
  $query = 'SELECT exc_title,exc_id,exc_duration,exc_description
            FROM Excursion ';
  $exc = $db->prepare($query);
  $exc->execute();
  $excursion = $exc->fetchAll();
  $exc->closeCursor();

  $query = 'SELECT *
  FROM   Tour_excursion
  WHERE  Tour_excursion.exc_id =?';

  $tr = $db->prepare($query);
  foreach ($excursion as $t) {
    $tr->bindValue(1, $t['exc_id']);
    $tr->execute();
    $tour[] = $tr->fetch();
  }
  $tr->closeCursor();

  $today = (new DateTime())->add(new DateInterval("P1D"))->format("Y/m/d");
  $query = 'SELECT  *
            FROM Tour_date
            WHERE tour_date >=? AND tour_id=?';

  $rce = $db->prepare($query);
  foreach ($tour as $t) {
    $rce->bindValue(1, $today);
    $rce->bindValue(2, $t['tour_id']);
    $rce->execute();
    $tour_date[] = $rce->fetch();
  }
  $rce->closeCursor();

  $query = 'SELECT Excursion_image.img_name,exc_id
            FROM Excursion_image 
            WHERE exc_id=?';
  $img = $db->prepare($query);
  foreach ($excursion as $t) {
    $img->bindValue(1, $t['exc_id']);
    $img->execute();
    $images[] = $img->fetch();
  }
  $img->closeCursor();

  $query = 'SELECT sum(review)/count(review) 
        FROM 1517_TOURS_AND_EXCURSION.Review
        WHERE exc_id=?';
  $rev = $db->prepare($query);
  foreach ($excursion as $t) {
    $rev->bindValue(1, $t['exc_id']);
    $rev->execute();
    $review[] = $rev->fetch();
  }
  $rev->closeCursor();
  for ($i = 0; $i < count($excursion); $i++) {
    $arr[$i] = array($tour_date[$i]['tour_price'], $tour_date[$i]['tour_date'], $tour[$i]['tour_starting_point'], $tour[$i]['tour_time_start'], $images[$i]['img_name'], $excursion[$i]['exc_title'], $excursion[$i]['exc_description'], round($review[$i][0], 0), $excursion[$i]['exc_duration'], $excursion[$i]['exc_id']);
  }

  if ($sort == 'asc') {
    asort($arr);
    return $arr;
  }
  if ($sort == 'desc') {
    arsort($arr);
    return $arr;
  }
  return   $arr;
}
function get_images($exc_id)
{
  global $db;
  $query = 'SELECT img_name
            FROM Excursion_image 
            WHERE exc_id=?';
  $img = $db->prepare($query);

  $img->bindValue(1, $exc_id);
  $img->execute();
  $images = $img->fetchAll();
  $img->closeCursor();
  return $images;
}
//================================
//single excursion
//===============================
function get_single_excursion($exc_id)
{
  global $db;
  $query = 'SELECT sum(review)/count(review) AS average, count(*) AS total_count,  Excursion.*
            FROM Excursion 
            JOIN Review USING(exc_id) 
            WHERE exc_id=?';
  $exc = $db->prepare($query);
  $exc->bindValue(1, $exc_id);
  $exc->execute();
  $excursion = $exc->fetch();
  $exc->closeCursor();

  return $excursion;
}
function get_tour_excursion($exc_id)
{
  global $db;
  $query = 'SELECT *
            From Tour_excursion 
            WHERE exc_id=?';
  $exc = $db->prepare($query);
  $exc->bindValue(1, $exc_id);
  $exc->execute();
  $tour = $exc->fetchAll();
  $exc->closeCursor();

  $query = 'SELECT *
            From Tour_date 
            WHERE tour_id=?';
  $exc = $db->prepare($query);

  foreach ($tour as $e) {
    $exc->bindValue(1, $e['tour_id']);
    $exc->execute();
    $tour_date[$e['tour_id']] = $exc->fetchAll();
  }
  $exc->closeCursor();

  // var_dump($tour_date[$tour[0]['tour_id']]);

  foreach ($tour as $t) {
    foreach ($tour_date[$t['tour_id']] as $d) {
      if ($d['tour_id'] == $t['tour_id']) {
        $arr[] = array('tour_starting_point' => $t['tour_starting_point'], 'tour_time_start' => $t['tour_time_start'], 'tour_date' => $d['tour_date'], 'tour_price' => $d['tour_price'], 'tour_price_kids' => $d['tour_price_kids']);
      }
    }
  }
  return $arr;
}

//===================
//get all review
//===================
function get_review($exc_id)
{
  global $db;
  $query = 'SELECT Review.*, member_name, member_surname
          FROM Review
          JOIN Member USING(member_id)
          Where exc_id=?';

  $rev = $db->prepare($query);
  $rev->bindValue(1, $exc_id);

  $rev->execute();
  $tour_date = $rev->fetchAll();
  $rev->closeCursor();
  return $tour_date;
}
