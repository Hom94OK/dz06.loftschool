<?php
//
//1.
//2. список всех заказов.
//
require_once ('connect-pdo.php');

echo 'Cписок всех зарегистрированных пользователей:';
$result = $pdo->prepare("SELECT * FROM users");
$data = $result->fetchAll(PDO::FETCH_ASSOC);


echo '<pre>';
print_r($result);
die();
