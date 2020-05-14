<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;

require_once '../vendor/autoload.php';

// TODO: edit_link.php page
// TODO: delete_link.php page

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('main_page.twig');
