<?php

use LinkShortener\Loader\TemplateLoader;

require_once '../vendor/autoload.php';

$templateLoader = new TemplateLoader();
$templateLoader->renderStaticTemplate('sign_in_page.twig');
