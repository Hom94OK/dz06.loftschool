<?php

require_once __DIR__ . '/vendor/autoload.php';

$routes = explode('/', $_SERVER['REQUEST_URI']);

$controller_name = 'index';
// получаем контроллер
if (!empty($routes[1])) {
    $controller_name = $routes[1];
}

$filename = "template/".strtolower($controller_name).'.twig';

if ($controller_name == 'admin-panel') {
    require_once __DIR__ . '/template/admin-panel.php';
    die();
} elseif (!file_exists($filename)) {
    echo 'Простите, такой страницы нет.';
    die();
}

//echo '<pre>';
//print_r($controller_name);

/**
 * TWIG
 */
$loader = new \Twig_Loader_Filesystem(__DIR__.'/template');
$twig = new \Twig_Environment($loader);

$title = 'Zagolovok';

echo $twig->render($controller_name.'.twig', [
        'title' => $title
]);


/**
 * intervention/image
 */

// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

// create Image from file
$manager = new ImageManager(['driver' => 'gd']);
$watermark = $manager->make(__DIR__ . '/img/icons/mark.png');

for ($i = 1; $i <= 4; $i++) {
    $manager->make(__DIR__ . "/img/content/burgers-do/$i.png")
            ->rotate(10)
            ->insert($watermark->resize(55, 45), 'bottom-right', 10, 10)
            ->resize(200, 200)
            ->save(__DIR__ . "/img/content/burgers/$i.png");
}