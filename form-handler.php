<?php


//echo "<pre>";
//print_r($_POST);
//echo '</pre>';
require_once("connect-pdo.php");

if (empty($_POST['Имя']) || empty($_POST['Телефон']) ||
	empty($_POST['email']) || empty($_POST['Улица']) ||
	empty($_POST['Дом']) || empty($_POST['Комментарий'])) {

	echo '<b class="error-message">Заполните обязательные поля.</b>';
	die();

} elseif (!empty($_POST['Имя']) || !empty($_POST['Телефон']) ||
	!empty($_POST['email']) || !empty($_POST['Улица']) ||
	!empty($_POST['Дом']) || !empty($_POST['Корпус']) || !empty($_POST['Квартира']) ||
	!empty($_POST['Этаж']) || !empty($_POST['Комментарий'])) {
	switch (true) {
		case preg_match('|[!@#$%^&*()_\-+=\|\\\[\{\}\.\,\?A-z]|', $_POST['Имя']):
			echo 'Поле "Имя" должны быть только буквы';
			die();
			break;
		case empty(preg_match('|^\+7 \(\d{3}\) \d{3} \d{2} \d{2}$|', $_POST['Телефон'])):
			echo 'Поле "Телефон" должно быть заполнено и иметь подобный вид: +7 (777) 777 77 77';
			die();
			break;
		case empty(preg_match('|[a-z0-9]+[_a-z0-9\.-]*[a-z0-9]+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})|', $_POST['email'])):
			echo 'email введен неверно';
			die();
			break;
		case preg_match('|[!@#$%^&*()_\-+=\|\\\[\{\}\.\,\?A-z]|', $_POST['Улица']):
			echo 'Поле "Улица" должны быть только русские буквы';
			die();
			break;
		case preg_match('|\D|', $_POST['Дом']):
			echo 'Поле "Дом" должны быть только числа';
			die();
			break;
		case preg_match('|[!@#$%^&*()_\-+=\|\\\[\{\}\.\,\?]|', $_POST['Корпус']):
			echo 'Поле "Корпус" содержит нежелательные символы';
			die();
			break;
		case preg_match('|\D|', $_POST['Квартира']):
			echo 'Поле "Квартира" должны быть только числа';
			die();
			break;
		case preg_match('|\D|', $_POST['Этаж']):
			echo 'Поле "Этаж" должны быть только числа';
			die();
			break;
		case preg_match('|[!@#$%^&*()_\-+=\|\\\[\{\}\.\,\?A-z]|', $_POST['Комментарий']):
			echo 'Поле "Комментарий" должны быть только русские буквы';
			die();
			break;
	}
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
		$user_email = $check_data['email'];

		echo '<strong class="registration-no">Вы не зарегистрированы.</strong><br><b>Вам присвоено ID пользователя:</b> ';
		print_r($user_id);
		echo '<br>';
	}


// Заносим в базу заказ
	$order_bd = $pdo->prepare("INSERT INTO `burgers-shop`.orders
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
	$result = $pdo->prepare("SELECT * FROM orders WHERE `ID пользователя` = :userid");
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
		foreach ($str as $key => $value) {
			echo '<td>' . $value . '</td>';
		}
		echo '</tr>';
		$last_order_id = $str['ID заказа'];
	}
	echo "</table>";

//	require_once __DIR__ . '/mail.php';
////
//	$to = $user_email;
//
//	$subject = 'Ваш заказ будет доставлен по адресу: ул. ' . $_POST['Улица'];
//	$subject .= ' ' . $_POST['Дом'] . $_POST['Корпус'] . ' кв.' . $_POST['Квартира'];
//	$subject .= ' этаж ' . $_POST['Этаж'] . ' - заказ №' . $last_order_id;
//
//	$message = 'DarkBeefBurger за 500 рублей, 1 шт \r\n';
//	$message .= 'Спасибо! Это уже ' . $last_order_id . ' заказ.';
//
//	$mail = mail($to, $subject, $message);
//	if ($mail) {
//		echo "Сообщение принято для доставки проверьте почту.";
//	} else {
//		echo "Произошла какая-то ошибка при отправке.";
//	}
	die();
}
