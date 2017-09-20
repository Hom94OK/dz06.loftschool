<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';
////
//$to = $user_email;
//
//$subject = 'Ваш заказ будет доставлен по адресу: ул. ' . $_POST['Улица'];
//$subject .= ' ' . $_POST['Дом'] . $_POST['Корпус'] . ' кв.' . $_POST['Квартира'];
//$subject .= ' этаж ' . $_POST['Этаж'] . ' - заказ №' . $last_order_id;
//
//$message = 'DarkBeefBurger за 500 рублей, 1 шт \r\n';
//$message .= 'Спасибо! Это уже ' . $last_order_id . ' заказ.';
//
//$mail = mail($to, $subject, $message);
//if ($mail) {
//	echo "Сообщение принято для доставки проверьте почту.";
//} else {
//	echo "Произошла какая-то ошибка при отправке.";
//}
die();

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
	$mail->setFrom('tarashomy4ok@gmail.com', 'Vasy');
	$mail->addAddress('khom.taras@gmail.com', 'Joe User');
	$mail->addReplyTo('info@example.com', 'Information');

	//Attachments
//	$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	//Content
	$mail->isHTML(true);
	$mail->Subject = 'Here is the subjectsss';
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->send();
	echo 'Message has been sent';
} catch (Exception $e) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
}