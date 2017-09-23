<?php

// CONNECT
$host = 'localhost';
$db = 'burgers-shop';
$user = 'root';
$pass = '';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);

$pdo->query("CREATE DATABASE IF NOT EXISTS `burgers-shop`");
$pdo->query('use `burgers-shop`;');
$pdo->query("CREATE TABLE IF NOT EXISTS `burgers-shop`.users (
    `ID пользователя` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(100),
    Имя VARCHAR(120),
    `Номер телефону` VARCHAR(80)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$pdo->query("CREATE TABLE IF NOT EXISTS `burgers-shop`.orders (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

