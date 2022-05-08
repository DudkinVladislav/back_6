<html lang="ru">
  <head>
    <meta charset="utf-8">
<style>body { margin:0;
	display:flex;
	flex-direction:column;
text-align:center;
background-color:#ff9911;}
	  /* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
	border: 2px solid red;
	}
	  </style>
<title>Задание 6</title>
</head>
</html>
<?php
/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.

header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
if (!empty($_POST['delete_id']))
{
$db = new PDO('mysql:host=localhost;dbname=u46613', 'u46613', '1591065', array(PDO::ATTR_PERSISTENT => true));
$stmt31 = $db->prepare("SELECT * FROM application WHERE id = ?");
$stmt31 -> execute([$_POST['delete_id']]);
$row31 = $stmt31->fetch(PDO::FETCH_ASSOC);
if (!$row31) 
{
    header('Location: ?delete_error=1');
    exit();
}
else
{
$stmt111 = $db->prepare("DELETE FROM login_pass WHERE id = ?");
$stmt111 -> execute([$_POST['delete_id']]);
$stmt4 = $db->prepare("DELETE FROM abilities WHERE id = ?");
$stmt4 -> execute([$_POST['delete_id']]);
$stmt3 = $db->prepare("DELETE FROM application WHERE id = ?");
$stmt3 -> execute([$_POST['delete_id']]);
header('Location: ./');
}
}
if(!empty($_POST['redact_id']))
{
$db = new PDO('mysql:host=localhost;dbname=u46613', 'u46613', '1591065', array(PDO::ATTR_PERSISTENT => true));
$stmt5 = $db->prepare("SELECT * FROM application WHERE id = ?");
$stmt5 -> execute([$_POST['redact_id']]);
$row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
if (!$row5) 
{
    header('Location: ?redact_error=1');
    exit();
}
else
{
setcookie('redact_id', $_POST['redact_id'], time() + 60 * 60);
$values = array();
$values['name'] = strip_tags($row5['name']);
$values['email'] = strip_tags($row5['email']);
$values['date'] = $row5['date'];
$values['pol'] = $row5['pol'];
$values['parts'] = $row5['parts'];
$values['biography'] = strip_tags($row5['bio']);
$stmt32 = $db->prepare("SELECT * FROM abilities WHERE id = ?");
$stmt32 -> execute([$_POST['redact_id']]);
$abilities1 = array();
while($row32 = $stmt32->fetch(PDO::FETCH_ASSOC))
{
    array_push($abilities1, strip_tags($row32['ability']));
}
    $values['abilities'] = $abilities1;
}
include('form.php');
}
else{
if(!empty($_POST['pol']))
   {
     $errors = array();
$errors['name']=0;
$errors['email']=0;
$errors['date']=0;
$errors['pol']=0;
$errors['parts']=0;
$errors['biography']=0;
     $errors1 = FALSE;
if (empty($_POST['name'])) {
 $errors['name']=1;
    $errors1 = TRUE;
}
if (empty($_POST['email'])) {
   $errors['email']=1;
    $errors1 = TRUE;
  }
if (empty($_POST['date'])) {
    $errors1 = TRUE;
    $errors['date']=1;
  }
  if (empty($_POST['pol'])) {
    $errors1 = TRUE;
    $errors['pol']=1;
  }
   if (empty($_POST['parts'])) {
    $errors1 = TRUE;
     $errors['parts']=1;
  }
if (empty($_POST['biography'])) {
    $errors1 = TRUE;
  $errors['biography']=1;
  }
   if(!empty($_POST['abilities'])){
    $json = json_encode($_POST['abilities']);
    setcookie ('abilities_value', $json, time() + 12 * 31 * 24 * 60 * 60);
  }
if ($errors1) {
// Выдаем сообщения об ошибках.
 if ($errors['name']) {
    // Выводим сообщение.
    $messages[] = '<div class="error"> Неверный ввод имени.</div>';
  }
 if ($errors['email']) {
    $messages[] = '<div class="error">Неправельный ввод email.</div>';
  }
 if ($errors['date']) {
    $messages[] = '<div class="error">Выберите дату.</div>';
  }
 if ($errors['pol']) {
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
 if ($errors['parts']) {
    $messages[] = '<div class="error">Укажите количество конечностей.</div>';
  }
  if ($errors['biography']) {
    $messages[] = '<div class="error">Раскажите о себе.</div>';
  }
  $values = array();
$values['name'] = strip_tags($_POST['name']);
$values['email'] = strip_tags($_POST['email']);
$values['date'] = $_POST['date'];
$values['pol'] = $_POST['pol'];
$values['parts'] = $_POST['parts'];
$values['biography'] = strip_tags($_POST['biography']);
$values['abilities'] = $_POST['abilities']; 
  include('form1.php');
}
else {
 //Изменение данных в основной таблице
   $db = new PDO('mysql:host=localhost;dbname=u46613', 'u46613', '1591065', array(PDO::ATTR_PERSISTENT => true));
   $stmt222 = $db->prepare("UPDATE application SET name = ?, email = ?, date = ?, pol = ?, parts = ?, bio = ? WHERE id =?");
   $stmt222 -> execute([$_POST['name'], $_POST['email'], $_POST['date'], $_POST['pol'], $_POST['parts'], $_POST['biography'], $_COOKIE['redact_id']]);
   //Изменение данных в таблице способностей 
    $stmt222 = $db->prepare("DELETE FROM abilities WHERE id = ?");
    $stmt222 -> execute([$_COOKIE['redact_id']]);
    $abilities = $_POST['abilities'];
    foreach($abilities as $item) {
      $stmt232 = $db->prepare("INSERT INTO abilities SET id = ?, ability = ?");
      $stmt232 -> execute([$_COOKIE['redact_id'], $item]);
    }
  // Делаем перенаправление.
  header('Location: index.php');
}
}
}
}
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
$db = new PDO('mysql:host=localhost;dbname=u46613', 'u46613', '1591065', array(PDO::ATTR_PERSISTENT => true));
  $stmt1 = $db->prepare("SELECT id, pass FROM admin WHERE login = ?");
  $stmt1 -> execute([$_SERVER['PHP_AUTH_USER']]);
  $row = $stmt1->fetch(PDO::FETCH_ASSOC);
  if (!$row || 
       md5($_SERVER['PHP_AUTH_PW']) != $row['pass']) 
{
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}
print('<br>Вы успешно авторизовались и видите защищенные паролем данные.<br><br>');
if(!empty($_GET['delete_error']))
{print('<div class=error>Пользователя с таким id не существует!</div><br>');} 
if(!empty($_GET['redact_error']))
{print('<div class=error>Пользователя с таким id не существует!</div><br>');}
// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
 $stmt2 = $db->prepare("SELECT id FROM application");
 $stmt2 -> execute();
 $ids = array();

while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
      array_push($ids, $row['id']);
    }
foreach($ids as $item) {
 $stmt12 = $db->prepare("SELECT * FROM abilities WHERE id = ?");
    $stmt12 -> execute([$item]);
$abilities = array();
while($row2 = $stmt12->fetch(PDO::FETCH_ASSOC)){
      array_push($abilities, strip_tags($row2['ability']));
    }
$stmt22 = $db->prepare("SELECT * FROM application WHERE id = ?");
    $stmt22 -> execute([$item]);
    $row3 = $stmt22->fetch(PDO::FETCH_ASSOC);
$name = $row3['name'];
$email = $row3['email'];
$date = $row3['date'];
$pol = $row3['pol'];
$part = $row3['parts'];
$bio = $row3['bio'];
$powers= implode(", ", $abilities);
printf("id - $item, Name - $name, Email - $email, Date - $date, Pol - $pol, Parts - $part, Abilities - $powers");
print('<br>');
printf("Biography - $bio");
print('<br>');
print('<br>');
}
$stmt10 = $db->prepare("SELECT COUNT(id_ab) AS 'kolvo' FROM abilities WHERE ability = ?");
$stmt10 -> execute(['levitation']);
$row10 = $stmt10->fetch(PDO::FETCH_ASSOC);
$stmt20 = $db->prepare("SELECT COUNT(id_ab) AS 'kolvo' FROM abilities WHERE ability = ?");
$stmt20 -> execute(['intangibility']);
$row20 = $stmt20->fetch(PDO::FETCH_ASSOC);
$stmt30 = $db->prepare("SELECT COUNT(id_ab) AS 'kolvo' FROM abilities WHERE ability = ?");
$stmt30 -> execute(['immortality']);
$row30 = $stmt30->fetch(PDO::FETCH_ASSOC);
$levitations=$row10['kolvo'];
$intangibilities=$row20['kolvo'];
$immortalities=$row30['kolvo'];
printf("Users with immortality - $immortalities");
print('<br>');
printf("Users with intangibility - $intangibilities");
print('<br>');
printf("Users with levitation - $levitations");
print('<br>');
print('<br>');
}
?>
    <form action="" method="POST">
      <input type="text" name="redact_id" placeholder="id"/>
      <input type="submit" name="submit" id="submit" value="Изменить данные пользователя" />
    </form>
<br>
 <form action="" method="POST">
      <input type="text" name="delete_id" placeholder="id"/>
      <input type="submit" name="submit" id="submit" value="Удалить данные о пользователе" />
    </form>
<a href="index.php" class = "gradient-button"  title = "return">Вернуться к списку данных</a>