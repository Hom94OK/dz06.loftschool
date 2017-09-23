<?php
require __DIR__."/vendor/autoload.php";

$remoteIp = $_SERVER['REMOTE_ADDR'];
$gRecaptchaResponse = $_REQUEST['g-recaptcha-response'];
$recaptcha = new \ReCaptcha\ReCaptcha("6LdFaS0UAAAAAKK8_v2qiYuNf_Cq6BHjo17B_b95");
$resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);
if ($resp->isSuccess()) {
	echo "Успех, капча пройдена";
} else {
	echo "Поражен вашей неудачей, сударь";
}