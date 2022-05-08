﻿﻿<html lang="ru">
  <head>
    <meta charset="utf-8">
<style>body { margin:0;
	display:flex;
	flex-direction:column;
text-align:center;
background-color:#ff9911;}
header {display:flex;
flex-direction: column;
text-align: center;
background-color:#dc3545}
	  /* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
	border: 2px solid red;
	}
	  </style>
    <title>Задание 6</title>
  </head>
  <body>
	  <?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
	  // Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
	   <?php
        if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']))
          print('<h3 id="form"> Форма в режиме редактирования </h3>');
        else
          print('<h3 id="form"> Форма </h3>');
        ?>
	  <br>
	  <br>
	<form action="" method="POST">
		Имя:
	<br>
      <input type="text" name="name" value="<?php print $values['name']; ?>" />
        <br> email:<br>
	<input type="email" name="email" value="<?php print $values['email']; ?>" />
        <br>Дата рождения:<br>
	<input type="date" name="date" value="<?php print $values['date']; ?>" />
	<br>Пол:<br> 
        <input type="radio" name="pol" value="man" <?php if ($values['pol'] == 'man') {print 'checked';} ?>> Мужской
        <input type="radio" name="pol" value="woman" <?php if ($values['pol'] == 'woman') {print 'checked';} ?>> Женский
      </div>
		<br>
	Количество конечностей:<br>
	<input type="radio" name="parts" value="1" <?php if ($values['parts'] == '1') {print 'checked';} ?>> 1 конечность
        <input type="radio" name="parts" value="2" <?php if ($values['parts'] == '2') {print 'checked';} ?>> 2 конечности
        <input type="radio" name="parts" value="3" <?php if ($values['parts'] == '3') {print 'checked';} ?>> 3 конечности
        <input type="radio" name="parts" value="4" <?php if ($values['parts'] == '4') {print 'checked';} ?>> 4 конечности 
      </div>
	<br>
	Сверхспособности:
	<br>
        <select name="abilities[]" multiple="true">
		<option value="immortality" <?php if (in_array("immortality", $values['abilities'])) {print 'selected';} ?>>Бессмертие</option>
		<option value="intangibility" <?php if (in_array("intangibility", $values['abilities'])) {print 'selected';} ?>>Прохождение сквозь стены</option>
		<option value="levitation" <?php if (in_array("levitation", $values['abilities'])) {print 'selected';} ?>>Левитация</option>
        </select>
	<br>
	Биография:
	<br>
        <textarea name="biography" style="margin: 0px; height: 69px; width: 180px;"><?php print $values['biography']; ?></textarea>
<br><br>
		<input type="submit"  name="submit" id="submit" value="Отправить" />
		<br>
    </form>
	 
</body></html>
