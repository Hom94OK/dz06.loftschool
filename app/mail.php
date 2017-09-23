<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//
$to = $user_email;
//

$subject = 'Ваш заказ будет доставлен по адресу: ул. ' . $_POST['Улица'];
$subject .= ' ' . $_POST['Дом'] . $_POST['Корпус'] . ' кв.' . $_POST['Квартира'];
$subject .= ' этаж ' . $_POST['Этаж'] . ' - заказ №' . $last_order_id;
//
$message = 'DarkBeefBurger за 500 рублей, 1 шт' . PHP_EOL;
$message .= 'Спасибо! Это уже ' . $last_order_id . ' заказ.';

$mail = new PHPMailer(true);
try {
	//Server settings
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'tarashomy4ok@gmail.com';
	$mail->Password = 'gmail1995';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	//Recipients
	$mail->setFrom('tarashomy4ok@gmail.com', 'MR.Burger');
	$mail->addAddress($_POST['email'], 'Хазяын');
	$mail->addReplyTo('tarashomy4ok@gmail.com', 'Information');

	//Attachments
//	$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	//Content
	$mail->CharSet="UTF-8";     // Кодыровка
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body    = $message;
//	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->send();
	echo 'Message has been sent';
} catch (Exception $e) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
}