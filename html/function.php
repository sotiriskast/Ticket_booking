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
  $query = 'SELECT member_email, member_passwd,member_name,member_id
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
    return true;
  }
}


function random_resv_id()
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

  $query = 'SELECT resv_id FROM Reservation WHERE resv_id=:id';
  $mb_id = $db->prepare($query);
  $mb_id->bindValue(':id', $id);
  $mb_id->execute();
  $chk = $mb_id->fetch();
  $mb_id->closeCursor();

  if ($chk != null) {
    //use recursive if is exist to call again the method
    return random_resv_id();
  } else {
    return $id;
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

  if ($chk != null) {
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
    $arr[$i] = array($recent[$i]['tour_date'], $recent[$i]['tour_price'], $tour[$i]['tour_starting_point'], $tour[$i]['tour_time_start'], $images[$i]['img_name'], $name_exc[$i]['exc_title'], $images[$i]['exc_id']);
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


function browse_event($id)
{
  global $db;
  $query = 'SELECT exc_title,exc_id
            FROM Excursion
            WHERE exc_id=? ';

  $exc = $db->prepare($query);
  $exc->bindValue(1, $id);
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

  $arr = array($tour_date[0]['tour_date'], $tour_date[0]['tour_price'], $tour[0]['tour_starting_point'], $tour[0]['tour_time_start'], $images[0]['img_name'], $excursion[0]['exc_title'], $excursion[0]['exc_id']);



  return   $arr;
}
function dispaly_availability($exc_id, $date, $starting_point = null)
{
  global $db;

  if ($starting_point == null) {
    $query = 'SELECT  DISTINCT tour_starting_point  FROM Tour_excursion';
    $exc = $db->prepare($query);
    $exc->execute();
    $availabiltiy = $exc->fetchAll();
    $exc->closeCursor();
    foreach ($availabiltiy as $e) {
      $starting_point .= $e[0] . '|';
    }
    $starting_point = substr($starting_point, 0, -1);
  }

  $query = 'SELECT E.exc_id,E.exc_title,E.exc_duration,E.exc_availability,
                   T.tour_id,T.tour_starting_point,T.tour_time_start,
                   D.tour_date,D.tour_price,D.tour_price_kids,
                   S.gd_ssn, S.gd_name,S.gd_surname
            FROM   Tour_excursion T
            JOIN Guide_tour G USING(tour_id)
            JOIN Tour_date D USING(tour_id)
            JOIN Excursion E USING(exc_id)
            JOIN Guide_staff S ON G.gd_ssn=S.gd_ssn
            WHERE  T.exc_id =? 
            AND tour_date=? AND tour_starting_point REGEXP ?';

  $exc = $db->prepare($query);
  $exc->bindValue(1, $exc_id);
  $exc->bindValue(2, $date);
  $exc->bindValue(3, $starting_point);
  $exc->execute();
  $availabiltiy = $exc->fetchAll();
  $exc->closeCursor();
  return $availabiltiy;
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
    //position 0 (price)
    //position 1 (date)
    //position 2 (starting point)
    //position 3 (time)
    //position 4 (image)
    //position 5 (title)
    //position 6 (description)
    //position 7 (rating)
    //position 8 (Duration)
    //position 9 Excursion ID
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


//==========
//GET IMAGES
//==========
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

function insert_review($member_id,$exc_id,$rating,$comment)
{


  global $db;
  $query = 'INSERT INTO Review(member_id,exc_id,review,review_comment)
            VALUES  (:MID,:EID,:REV,:COM)';

  $rev = $db->prepare($query);
  $rev->bindValue(':MID', $member_id);
  $rev->bindValue(':EID', $exc_id);
  $rev->bindValue(':REV', $rating);
  $rev->bindValue(':COM', $comment);


  if($rev->execute()){
    $rev->closeCursor();
    return true;  
  }else{
    $rev->closeCursor();
  return false;
  }

  
}
//GET ALL WISH LIST EXCURSION
//WISH LIST
//============================

function is_in_wish_list($member, $tour)
{
  global $db;
  $query = 'SELECT *
         FROM Wish_list
         WHERE exc_id=? AND member_id=?';
  $find = $db->prepare($query);
  $find->bindValue(1, $tour);
  $find->bindValue(2, $member);
  $find->execute();
  if ($find->fetch() == null) {
    $find->closeCursor();
    return false;
  } else {
    $find->closeCursor();
    return true;
  }
}

//insert into wash list
function insert_wish_list($member, $tour)

{
  global $db;
  if (is_in_wish_list($member, $tour) == false) {
    $query = 'INSERT INTO Wish_list(exc_id,member_id)
              VALUES(?,?)';
    $add = $db->prepare($query);
    $add->bindValue(1, $tour);
    $add->bindValue(2, $member);
    if ($add->execute()) {
      $add->closeCursor();
      return true;
    }
    $add->closeCursor();
    return false;
  } else {
    $query = 'DELETE FROM Wish_list
           WHERE exc_id=? AND member_id=?
           limit 1';
    $rm = $db->prepare($query);
    $rm->bindValue(1, $tour);
    $rm->bindValue(2, $member);
    if ($rm->execute()) {
      $rm->closeCursor();
      return false;
    }
    $rm->closeCursor();
    return true;
  }
}
function get_wish_list($member_id)
{
  global $db;
  $query = 'SELECT exc_id
            FROM Wish_list
            WHERE member_id=?';
  $find = $db->prepare($query);
  $find->bindValue(1, $member_id);
  $find->execute();
  $wish = $find->fetchAll();
  $find->closeCursor();
  return $wish;
}

function get_wish_excursion($exc_id)
{
  global $db;
  $query = 'SELECT exc_title,exc_id,exc_duration,exc_description
            FROM Excursion
            WHERE exc_id=?';
  $exc = $db->prepare($query);
  $exc->bindValue(1, $exc_id);
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

  return   $arr;
}
function get_lanquage($gd_ssn)
{
  global $db;
  $query = 'SELECT * FROM Guide_language
            WHERE gd_ssn=?';
  $lan = $db->prepare($query);
  $lan->bindValue(1, $gd_ssn);
  $lan->execute();
  $lang = $lan->fetchAll();
  $lan->closeCursor();
  return $lang;
}
function count_booking($tour_id, $date)
{
  global $db;
  $query = 'SELECT sum(par_qnt)
            FROM 1517_TOURS_AND_EXCURSION.Reservation
            JOIN Participant USING(resv_id)
            where tour_id=? AND resv_status="Confirm" AND resv_date=?';
  $lan = $db->prepare($query);
  $lan->bindValue(1, $tour_id);
  $lan->bindValue(2, $date);
  $lan->execute();
  $total = $lan->fetchAll();
  $lan->closeCursor();
  return $total;
}


function insert_new_reservation($resv_id, $member_id, $tour_id, $date, $price)
{

  global $db;
  $query = 'INSERT INTO Reservation()
            VALUES(:id,:details,:status,:member_id,:tour_id,:date,:price)';
  $lan = $db->prepare($query);
  $lan->bindValue(':id', $resv_id);
  $lan->bindValue(':details', null);
  $lan->bindValue(':status', 'Confirm');
  $lan->bindValue(':member_id', $member_id);
  $lan->bindValue('tour_id', $tour_id);
  $lan->bindValue(':date', $date);
  $lan->bindValue(':price', $price);
  if ($lan->execute()) {
    $lan->closeCursor();
    return true;
  } else {
    $lan->closeCursor();
    return false;
  }
}

function update_count_booking($exc_id, $count = 'PLUS')
{
  global $db;
  $query = 'SELECT exc_count_booking 
            FROM Excursion
            WHERE exc_id=:id';
  $lan = $db->prepare($query);
  $lan->bindValue(':id', $exc_id);
  $lan->execute();
  $cnt = $lan->fetch();
  $lan->closeCursor();

  if ($count == 'PLUS') {
    $cnt++;
  } elseif ($count == 'MINUS') {
    $cnt--;
  }
  $query = 'UPDATE Excursion
            SET exc_count_booking =:count
            WHERE exc_id=:id';
  $lan = $db->prepare($query);
  $lan->bindValue(':id', $exc_id);
  $lan->bindValue(':count', $cnt);
  if ($lan->execute()) {
    $lan->closeCursor();
    return true;
  } else {
    $lan->closeCursor();
    return false;
  }
}
function cancel_reservation($resv_id)
{
  global $db;
  $query = 'UPDATE  Reservation 
            SET resv_status=:cnx
            WHERE resv_id=:id';
  $lan = $db->prepare($query);
  $lan->bindValue(':id', $resv_id);
  $lan->bindValue(':cnx', 'Cancelled');
  var_dump($lan->execute(), $resv_id);
  if ($lan->execute()) {

    $lan->closeCursor();
    return true;
  } else {
    $lan->closeCursor();
    return false;
  }
}

function insert_new_participant($resv_id, $person, $qnt)
{

  global $db;
  $query = 'INSERT INTO Participant()
            VALUES (:id,:person,:qnt)';
  $lan = $db->prepare($query);
  $lan->bindValue(':id', $resv_id);
  $lan->bindValue(':person', $person);
  $lan->bindValue(':qnt', $qnt);
  if ($lan->execute()) {
    $lan->closeCursor();
    return true;
  } else {
    $lan->closeCursor();
    return false;
  }
}
function get_member_order($member_id)
{
  $date = date('Y-m-d');

  global $db;
  $query = 'SELECT  M.member_name , M.member_surname ,
                      R.resv_status,R.resv_id, R.resv_date,R.resv_price,
                    T.*,
                    E.exc_title,E.exc_duration 
            FROM Member M
            JOIN Reservation R USING(member_id)
            JOIN Tour_excursion T ON T.tour_id=R.tour_id 
            JOIN Excursion E ON E.exc_id=T.exc_id 
            WHERE M.member_id=? AND R.resv_date>=? AND R.resv_status=?';
  $lan = $db->prepare($query);
  $lan->bindValue(1, $member_id);
  $lan->bindValue(2, $date);
  $lan->bindValue(3, 'Confirm');
  $lan->execute();
  $resv = $lan->fetchAll();
  $lan->closeCursor();

  $query = 'SELECT * 
          FROM Participant
          WHERE resv_id=?';
  $lan = $db->prepare($query);
  foreach ($resv as $e) {
    $lan->bindValue(1, $e['resv_id']);
    $lan->execute();
    $par[] = $lan->fetchAll();
  }
  $lan->closeCursor();

  $query = 'SELECT img_name
            FROM Excursion_image
            WHERE exc_id=?
            LIMIT 1';
  $lan = $db->prepare($query);
  foreach ($resv as $e) {
    $lan->bindValue(1, $e['exc_id']);
    $lan->execute();
    $img[] = $lan->fetch();
  }
  $lan->closeCursor();
  for ($i = 0; $i < count($resv); $i++) {
    $arr[] = array('resv' => $resv[$i], 'par' => $par[$i], 'img' => $img[$i]);
  }

  return $arr;
}

function get_member_history($member_id)
{
  global $db;
  $query = 'SELECT  M.member_name , M.member_surname ,
                      R.resv_status,R.resv_id, R.resv_date,R.resv_price,
                    T.*,
                    E.exc_title,E.exc_duration 
            FROM Member M
            JOIN Reservation R USING(member_id)
            JOIN Tour_excursion T ON T.tour_id=R.tour_id 
            JOIN Excursion E ON E.exc_id=T.exc_id 
            WHERE M.member_id=?
            ORDER BY R.resv_status DESC';
  $lan = $db->prepare($query);
  $lan->bindValue(1, $member_id);
  $lan->execute();
  $resv = $lan->fetchAll();
  $lan->closeCursor();

  $query = 'SELECT * 
          FROM Participant
          WHERE resv_id=?';
  $lan = $db->prepare($query);
  foreach ($resv as $e) {
    $lan->bindValue(1, $e['resv_id']);
    $lan->execute();
    $par[] = $lan->fetchAll();
  }
  $lan->closeCursor();

  $query = 'SELECT img_name
            FROM Excursion_image
            WHERE exc_id=?
            LIMIT 1';
  $lan = $db->prepare($query);
  foreach ($resv as $e) {
    $lan->bindValue(1, $e['exc_id']);
    $lan->execute();
    $img[] = $lan->fetch();
  }
  $lan->closeCursor();
  for ($i = 0; $i < count($resv); $i++) {
    $arr[] = array('resv' => $resv[$i], 'par' => $par[$i], 'img' => $img[$i]);
  }

  return $arr;
}
