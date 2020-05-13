<?php

use LinkShortener\Loader\TemplateLoader;

require_once '../vendor/autoload.php';

// TODO: links.php page
// TODO: edit_link.php page
// TODO: delete_link.php page

$templateLoader = new TemplateLoader();
$templateLoader->renderStaticTemplate('main_page.twig');
