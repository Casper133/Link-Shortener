<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseLinkRepository;

require_once '../vendor/autoload.php';

$linkRepository = DatabaseLinkRepository::getInstance();
$links = array('links' => $linkRepository->getAll());

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('links_page.twig', $links);
