<?php

require_once __DIR__ . '/vendor/autoload.php';

/**
 * TWIG
 */
$loader = new \Twig_Loader_Filesystem('/');
$twig = new \Twig_Environment($loader);

$title = 'Zagolovok';

echo $twig->render('index.html', [
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