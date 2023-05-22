<?php

$pass_hash=array();$user = 'u52991';
$pass = '4039190';	
$db = new PDO('mysql:host=localhost;dbname=u52991', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$pass_hash=array();
try{
  $get=$db->prepare("select pass from admin where user=?");
  $get->execute(array('admin'));
  $pass_hash=$get->fetchAll()[0][0];
}
catch(PDOException $e){
  print('Error: '.$e->getMessage());
}

if (empty($_SERVER['PHP_AUTH_USER']) ||
      empty($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_USER'] != 'admin' ||
      md5($_SERVER['PHP_AUTH_PW']) != $pass_hash) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Unauthorized (Требуется авторизация)</h1>');
    exit();
}
if(empty($_GET['edit_id'])){
  header('Location: admin.php');
}

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
    setcookie('fio_value', '', 100000);
    setcookie('email_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('gender_value', '', 100000);
    setcookie('bodyparts_value', '', 100000);
    setcookie('bio_value', '', 100000);
    setcookie('ability_value', '', 100000);
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $error=FALSE;
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['bodyparts'] = !empty($_COOKIE['bodyparts_error']);
  $errors['ability'] = !empty($_COOKIE['ability_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
    $error=TRUE;
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните email.</div>';
    $error=TRUE;
  }
  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните год.</div>';
    $error=TRUE;
  }
  if ($errors['gender']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните пол.</div>';
    $error=TRUE;
  }
  if ($errors['bodyparts']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bodyparts_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните кол-во конечностей.</div>';
    $error=TRUE;
  }
  if ($errors['ability']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('ability_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните суперспособность.</div>';
    $error=TRUE;
  }
  if ($errors['bio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните биографию.</div>';
    $error=TRUE;
  }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['1'] = 0;
  $values['2'] = 0;
  $values['3'] = 0;
  $values['4'] = 0;
  $user = 'u52991';
  $pass = '4039190';	
  $db = new PDO('mysql:host=localhost;dbname=u52991', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

  try{ 
    $id=$_GET['edit_id'];
    $stmt=$db->prepare("SELECT * FROM application WHERE id=?");
    $stmt->bindParam(1,$id); //$stmt->bindParam(1,$arr[0]['id']);
    $stmt->execute();
    $arr1=$stmt->fetchALL();
    $values['fio']=$arr1[0]['name'];
    $values['email']=$arr1[0]['email'];
    $values['year']=$arr1[0]['year'];
    $values['gender']=$arr1[0]['gender'];
    $values['bodyparts']=$arr1[0]['bodyparts'];
    $values['biography']=$arr1[0]['biography'];
   
    $stmt=$db->prepare("SELECT ability_id FROM ability_application WHERE application_id=?");
    $stmt->bindParam(1,$id); //$stmt->bindParam(1,$arr3[0]['id']);
    $stmt->execute();
    $inf2=$stmt->fetchALL();
      for($i=0;$i<count($inf2);$i++){
        if($inf2[$i]['ability_id']=='1'){
          $values['1']=1;
        }
        if($inf2[$i]['ability_id']=='2'){
          $values['2']=1;
        }
        if($inf2[$i]['ability_id']=='3'){
          $values['3']=1;
        }
        if($inf2[$i]['ability_id']=='4'){
          $values['4']=1;
        }
      }
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
    exit();
  }

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  if(!empty($_POST['save'])){
    $id=$_POST['dd'];
    $name = $_POST['fio'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $pol=$_POST['gender'];
    $limbs=$_POST['bodyparts'];
    $powers=$_POST['ability'];
    $bio=$_POST['bio'];
    // Проверяем ошибки.
    $errors = FALSE;
    if (empty($_POST['fio'])) {
      // Выдаем куку на день с флажком об ошибке в поле fio.
      setcookie('fio_error', '1', time() + 24 * 60 * 60);
      setcookie('fio_value', '', 100000);
      $errors = TRUE;
    }

    if (empty($_POST['email']) || !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i', $_POST['email'])) {
      // Выдаем куку на день с флажком об ошибке в поле email.
      setcookie('email_error', '1', time() + 24 * 60 * 60);
      setcookie('email_value', '', 100000);
      $errors = TRUE;
    }

    if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
      // Выдаем куку на день с флажком об ошибке в поле year.
      setcookie('year_error', '1', time() + 24 * 60 * 60);
      setcookie('year_value', '', 100000);
      $errors = TRUE;
    }

    if (empty($_POST['gender']) || ($_POST['gender']!='m' && $_POST['gender']!='f')) {
      // Выдаем куку на день с флажком об ошибке в поле gender.
      setcookie('gender_error', '1', time() + 24 * 60 * 60);
      setcookie('pol_value', '', 100000);
      $errors = TRUE;
    }
    if (empty($_POST['bodyparts']) || ($_POST['bodyparts']!='2' && $_POST['bodyparts']!='3' && $_POST['bodyparts']!='4' && $_POST['bodyparts']!='cannot count')) {
      // Выдаем куку на день с флажком об ошибке в поле bodyparts.
      setcookie('bodyparts_error', '1', time() + 24 * 60 * 60);
      setcookie('bodyparts_value', '', 100000);
      $errors = TRUE;
    }

    foreach ($_POST['ability'] as $ability) {
      if (!is_numeric($ability) || !in_array($ability, [1, 2, 3, 4])) {
        setcookie('ability_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
        break;
      }
    }

    if (empty($_POST['bio']) || !preg_match('/^[0-9A-Za-z0-9А-Яа-я,\.\s]+$/', $_POST['bio'])) {
        // Выдаем куку на день с флажком об ошибке в поле bio.
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        setcookie('bio_value', '', 100000);
        $errors = TRUE;
    }

    if ($errors) {
      setcookie('save','',100000);
      header('Location: index.php?edit_id='.$id);
    }
    else{
      setcookie('fio_error', '', 1000000);
      setcookie('year_error', '', 1000000);
      setcookie('email_error', '', 1000000);
      setcookie('gender_error', '', 1000000);
      setcookie('bodyparts_error', '', 1000000);
      setcookie('ability_error', '', 1000000);
      setcookie('bio_error', '', 1000000);
    }

    $user = 'u52991';
    $pass = '4039190';	
    $db = new PDO('mysql:host=localhost;dbname=u52991', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    if(!$errors){
      $upd=$db->prepare("UPDATE application SET name=:name, email=:email, year=:byear, gender=:pol, bodyparts=:limbs, biography=:bio WHERE id=:id");
      $cols=array(
        ':name'=>$name,
        ':email'=>$email,
        ':byear'=>$year,
        ':pol'=>$pol,
        ':limbs'=>$limbs,
        ':bio'=>$bio
      );
      foreach($cols as $k=>&$v){
        $upd->bindParam($k,$v);
      }
      $upd->bindParam(':id',$id);
      $upd->execute();
      $del=$db->prepare("DELETE FROM ability_application WHERE application_id=?");
      $del->execute(array($id));
      $upd1=$db->prepare("INSERT INTO ability_application SET ability_id=:power, application_id=:id");
      $upd1->bindParam(':id',$id);
      foreach($powers as $pwr){
        $upd1->bindParam(':power',$pwr);
        $upd1->execute();
      }
    }
    if(!$errors){
      setcookie('save', '1');
    }
    header('Location: index.php?edit_id='.$id);
  }
  else{
    $id=$_POST['dd'];
     $user = 'u52991';
    $pass = '4039190';	
    $db = new PDO('mysql:host=localhost;dbname=u52991', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    try {
      $del=$db->prepare("DELETE FROM ability_application WHERE application_id=?");
      $del->execute(array($id));
      $stmt = $db->prepare("DELETE FROM application WHERE id=?");
      $stmt -> execute(array($id));
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  setcookie('del','1');
  setcookie('del_user',$id);
  header('Location: admin.php');
  }
  
}
