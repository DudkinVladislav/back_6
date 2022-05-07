<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
$db = new PDO('mysql:host=localhost;dbname=u46613', 'u46613', '1591065', array(PDO::ATTR_PERSISTENT => true));
  $stmt1 = $db->prepare("SELECT id, pass FROM admin WHERE login = ?");
  $stmt1 -> execute([$_SERVER['PHP_AUTH_USER']]);
  $row = $stmt1->fetch(PDO::FETCH_ASSOC);
  if ((!$row)||($row['pass'] != md5($_SERVER['PHP_AUTH_PW']))
    {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');
?>
// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
