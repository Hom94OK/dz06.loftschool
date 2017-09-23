<?php

require __DIR__ . "/../vendor/autoload.php";

$remoteIp = $_SERVER['REMOTE_ADDR'];
$gReCaptchaResponse = $_REQUEST['g-recaptcha-response'];
$reCaptcha = new \ReCaptcha\ReCaptcha("6Lf3izEUAAAAAJy7yt73pCDSwUip6GnVyrJ1DZio");
$resp = $reCaptcha->verify($gReCaptchaResponse, $remoteIp);
if ($resp->isSuccess()) {
//    echo "Успех, капча пройдена";
} else {
    echo '<b class="registration-no">Ошибка капчи</b>';
//    echo '<pre>';
//    print_r($resp->getErrorCodes()[0]);
    die();
}