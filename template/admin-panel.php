<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Адмін панель</title>
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
<h1>Адмін панель</h1><br>
<h2>Список всех зарегистрированных пользователей:</h2>
<?php
require_once __DIR__ . '/../app/connect-pdo.php';

$result = $pdo->prepare("SELECT * FROM `burgers-shop`.users");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);

echo '<table>';
echo '<tr>';
foreach ($data[0] as $key => $value) {
	echo '<th>' . $key . '</th>';
}
echo '</tr>';
foreach ($data as $str) {
	echo '<tr>';
	foreach ($str as $value) {
		echo '<td>' . $value . '</td>';
	}
	echo '</tr>';
}
echo "</table>";
?>
<h2>Список всех заказов:</h2>
<?php
$result = $pdo->prepare("SELECT * FROM `burgers-shop`.orders");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);

echo '<table>';
echo '<tr>';
foreach ($data[0] as $key => $value) {
	echo '<th>' . $key . '</th>';
}
echo '</tr>';
foreach ($data as $str) {
	echo '<tr>';
	foreach ($str as $value) {
		echo '<td>' . $value . '</td>';
	}
	echo '</tr>';
}
echo "</table>";
?>
</body>
</html>