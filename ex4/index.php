<?php
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
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
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
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните email.</div>';
  }
  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните год.</div>';
  }
  if ($errors['gender']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните пол.</div>';
  }
  if ($errors['bodyparts']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bodyparts_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните кол-во конечностей.</div>';
  }
  if ($errors['ability']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('ability_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните суперспособность.</div>';
  }
  if ($errors['bio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['fio_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['bodyparts'] = empty($_COOKIE['bodyparts_value']) ? '' : $_COOKIE['bodyparts_value'];
  $values['ability'] = empty($_COOKIE['ability_value']) ? array() : unserialize($_COOKIE['ability_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['fio'])) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('fio_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
else {
  // Сохраняем ранее введенное в форму значение на месяц.
  setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['email']) || !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i', $_POST['email'])) {
  // Выдаем куку на день с флажком об ошибке в поле email.
  setcookie('email_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
else {
  // Сохраняем ранее введенное в форму значение на месяц.
  setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  // Выдаем куку на день с флажком об ошибке в поле year.
  setcookie('year_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
else {
  // Сохраняем ранее введенное в форму значение на месяц.
  setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['gender']) || ($_POST['gender']!='m' && $_POST['gender']!='f')) {
  // Выдаем куку на день с флажком об ошибке в поле gender.
  setcookie('gender_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
else {
  // Сохраняем ранее введенное в форму значение на месяц.
  setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
}
if (empty($_POST['bodyparts']) || ($_POST['bodyparts']!='2' && $_POST['bodyparts']!='3' && $_POST['bodyparts']!='4' && $_POST['bodyparts']!='cannot count')) {
   // Выдаем куку на день с флажком об ошибке в поле bodyparts.
   setcookie('bodyparts_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
}
else {
  // Сохраняем ранее введенное в форму значение на месяц.
  setcookie('bodyparts_value', $_POST['bodyparts'], time() + 30 * 24 * 60 * 60);
}

foreach ($_POST['ability'] as $ability) {
  if (!is_numeric($ability) || !in_array($ability, [1, 2, 3, 4])) {
    setcookie('ability_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
    break;
  }
}
if (!empty($_POST['ability'])) {
  setcookie('ability_value', serialize($_POST['ability']), time() + 24 * 60 * 60);
}

if (empty($_POST['bio']) || !preg_match('/^[0-9A-Za-z0-9А-Яа-я,\.\s]+$/', $_POST['bio'])) {
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}

// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

$user = 'u52991'; // Заменить на ваш логин uXXXXX
$pass = '4039190'; // Заменить на пароль, такой же, как от SSH
$db = new PDO('mysql:host=localhost;dbname=u52991', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

// Подготовленный запрос. Не именованные метки.
try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, year = ?, gender = ?, bodyparts = ?, biography = ?");
  $stmt->execute([$_POST['fio'], $_POST['email'], $_POST['year'], $_POST['gender'], $_POST['bodyparts'], $_POST['bio']]);
  $app_id = $db->lastInsertId();
  $stmt = $db->prepare("INSERT INTO ability_application SET application_id = ?, ability_id=?");
  foreach ($_POST['ability'] as $ability) {
    $stmt->execute([$app_id,$ability ]);
  }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
