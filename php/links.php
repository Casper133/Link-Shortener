<?php

namespace LinkShortener;

use LinkShortener\Entity\Link;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\InMemoryLinkRepository;

require_once '../vendor/autoload.php';

$linkRepository = InMemoryLinkRepository::getInstance();

$firstLink = new Link();
$firstLink->setOriginalLink('https://google.com');
$firstLink->setShortLink('https://example.com/link-1');
$linkRepository->save($firstLink);

$secondLink = new Link();
$secondLink->setOriginalLink('https://google.com');
$secondLink->setShortLink('https://example.com/link-2');
$linkRepository->save($secondLink);

$thirdLink = new Link();
$thirdLink->setOriginalLink('https://google.com');
$thirdLink->setShortLink('https://example.com/link-3');
$linkRepository->save($thirdLink);

$links = array('links' => $linkRepository->getAll());

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplateWithContext('links_page.twig', $links);
