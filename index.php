<?php

require_once __DIR__ . '/vendor/autoload.php';

//use Twig_Environment;

$loader = new \Twig_Loader_Filesystem('/');
$twig = new \Twig_Environment($loader);

$title = 'Zagolovok';

echo $twig->render('index.html', [
	'title' => $title
]);