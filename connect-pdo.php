<?php

// CONNECT
$host = 'localhost';
$db = 'burgers-shop';
$user = 'root';
$pass = '';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);

//CREATE DATABASE не вышло
//$database = $pdo->query('SHOW DATABASES LIKE "burgers-shop"');
//if ($database->rowCount()==false) {
//	echo 'БД burgers-shop не найдена потому она будет создана.';
//	$pdo->query('CREATE DATABASE burgers-shops');
//}

$users = $pdo->query('SHOW TABLES LIKE "users"');
$order = $pdo->query('SHOW TABLES LIKE "orders"');
if (!($users->rowCount()) || !($order->rowCount())) {
	if (!($users->rowCount())) {
		echo '<b class="error-message">Таблица users не найдена потому она будет создана.</b><br>';
		$pdo->query('CREATE TABLE users
(
    `ID пользователя` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(100),
    Имя VARCHAR(120),
    `Номер телефону` VARCHAR(80)
)');
	}
	if (!($order->rowCount())) {
		echo '<b class="error-message">Таблица orders не найдена потому она будет создана.</b><br>';
		$pdo->query('CREATE TABLE orders
(
	`ID заказа` INT PRIMARY KEY AUTO_INCREMENT,
    `ID пользователя` INT,
    Улица VARCHAR(100),
    Дом INT,
    Корпус VARCHAR(10),
    Квартира VARCHAR(20),
    Этаж VARCHAR(20),
    Комментарий TEXT,
    Оплата VARCHAR(50),
    Перезвони VARCHAR(10)
)');
	}
	echo 'Попробуйте еще раз.';
	die();
}
