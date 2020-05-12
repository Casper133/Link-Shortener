<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

require_once 'vendor/autoload.php';

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader, [
    'cache' => 'vendor/cache',
]);

try {
    echo $twig->render('sign_in_page.twig');
} catch (LoaderError | RuntimeError | SyntaxError $e) {
    echo $e->getMessage();
}
