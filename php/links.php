<?php

use LinkShortener\Entity\Link;
use LinkShortener\Loader\TemplateLoader;

require_once '../vendor/autoload.php';

$firstLink = new Link();
$firstLink->setId(1);
$firstLink->setOriginalLink('https://google.com');
$firstLink->setShortLink('https://example.com/link-1');

$secondLink = new Link();
$secondLink->setId(2);
$secondLink->setOriginalLink('https://google.com');
$secondLink->setShortLink('https://example.com/link-2');

$thirdLink = new Link();
$thirdLink->setId(3);
$thirdLink->setOriginalLink('https://google.com');
$thirdLink->setShortLink('https://example.com/link-3');

$links = array($firstLink, $secondLink, $thirdLink);

$templateLoader = new TemplateLoader();
$templateLoader->loadLinksTemplate('links_page.twig', $links);
