<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

require_once 'vendor/autoload.php';

// TODO: links.php page
// TODO: sign_in.php page
// TODO: edit_link.php page
// TODO: delete_link.php page

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader, [
    'cache' => 'vendor/cache',
]);

try {
    echo $twig->render('main_page.twig');
} catch (LoaderError | RuntimeError | SyntaxError $e) {
    echo $e->getMessage();
}
