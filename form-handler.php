<?php

//echo '<pre>';
//var_dump($_POST);
//echo '</pre>';

$host = 'localhost';
$db = 'burgers-shop';
$user = 'root';
$pass = '';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);

//echo 'Дані замовлення <br>';
//foreach ($_POST as $key => $value) {
//	echo $key . ' - ' . $value . '<br>';
//}
//echo "<pre>";
//print_r($_POST);

if (empty($_POST['Имя']) || empty($_POST['Телефон']) ||
	empty($_POST['email']) || empty($_POST['Улица']) ||
	empty($_POST['Дом']) || empty($_POST['Корпус']) ||
	empty($_POST['Квартира']) || empty($_POST['Этаж']) ||
	empty($_POST['Комментарий'])) {
	echo '<b>Для оформления заказа необходимо заполнить следующие поля:</b><br>';
//	$cont = count($_POST);
//	$i = 0;

	foreach ($_POST as $key => $value) {
//		if ($cont === $i) {
//			echo $key;
//		} else
		if (empty($value)) {
			echo $key . ', ';
		}
//		$i++;
	}
} else {

// Проверка пользователя
	$email_check = $pdo->prepare("SELECT * FROM users WHERE email = :email");
	$email_check->execute([
		':email' => $_POST['email']
	]);
	$check_data = $email_check->fetch(PDO::FETCH_ASSOC);
	$user_id = $check_data['ID пользователя'];

// Проверка авторизации
	if (isset($check_data['email'])) {
		echo '<strong class="registration-ok">Вы зарегистрированный пользователь.</strong> <br>';
		echo '<b>ID пользователя:</b> ' . $user_id . ' ' . ' ' . '-' . ' ' . ' <b>Email пользователя:</b> ';
		print_r($check_data['email']);
		echo '<br>';
	} else {
		$user_bd = $pdo->prepare("INSERT INTO `burgers-shop`.users (email, Имя, `Номер телефону`) VALUES (:email, :name, :phone)");
		$user_bd->execute([
			':email' => $_POST['email'],
			':name' => $_POST['Имя'],
			':phone' => $_POST['Телефон']
		]);

		$email_check = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$email_check->execute([
			':email' => $_POST['email']
		]);
		$check_data = $email_check->fetch(PDO::FETCH_ASSOC);
		$user_id = $check_data['ID пользователя'];

		echo '<strong class="registration-no">Вы не зарегистрированы.</strong><br><b>Вам присвоено ID пользователя:</b> ';
		print_r($user_id);
		echo '<br>';
	}


// Заносим в базу заказ
	$order_bd = $pdo->prepare("INSERT INTO `burgers-shop`.`order`
	(`ID пользователя`, Улица, Дом, Корпус, Квартира, Этаж, Комментарий, Оплата, Перезвони)
	VALUES (:userid, :street, :home, :part, :appt, :floor, :comment, :payment, :callback)");
	$order_bd->execute([
		':userid' => $user_id,
		':street' => $_POST['Улица'],
		':home' => $_POST['Дом'],
		':part' => $_POST['Корпус'],
		':appt' => $_POST['Квартира'],
		':floor' => $_POST['Этаж'],
		':comment' => $_POST['Комментарий'],
		':payment' => $_POST['payment'],
		':callback' => $_POST['callback']
	]);
	$data = $order_bd->fetchAll(PDO::FETCH_ASSOC);


// Проверяем прошедшие заказы
	$result = $pdo->prepare("SELECT * FROM `order` WHERE `ID пользователя` = :userid");
	$result->execute([
		':userid' => $user_id
	]);
	$data = $result->fetchAll(PDO::FETCH_ASSOC);


// Выводим на экран все заказы пользователя
	echo '<b class="your-order">Ваши заказы:</b><table>';
	echo '<tr>';
	foreach ($data[0] as $key => $value) {
		echo '<th>' . $key . '</th>';
	}
	echo '</tr>';
	foreach ($data as $str) {
		echo '<tr>';
		// print_r($str);
		foreach ($str as $value) {
			echo '<td>' . $value . '</td>';
		}
		echo '</tr>';
	}
	echo "</table>";
	die();
}
////echo "<pre>";
////print_r($data);
////print_r($check_data);
