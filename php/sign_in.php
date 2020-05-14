<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;

require_once '../vendor/autoload.php';

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign_in_page.twig');
