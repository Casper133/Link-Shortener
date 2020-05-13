<?php

namespace LinkShortener\Loader;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TemplateLoader
{
    private Environment $twig;

    private const LINKS_KEY = 'links';

    /**
     * TemplateLoader constructor.
     */
    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader('../templates'));
    }

    /**
     * @param string $templateName
     */
    public function loadTemplate(string $templateName): void
    {
        if (!isset($this->twig)) {
            return;
        }

        try {
            echo $this->twig->render($templateName);
        } catch (LoaderError | RuntimeError | SyntaxError $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param string $templateName
     * @param array $links
     */
    public function loadLinksTemplate(string $templateName, array $links): void
    {
        if (!isset($this->twig)) {
            return;
        }

        try {
            echo $this->twig->render($templateName, [self::LINKS_KEY => $links]);
        } catch (LoaderError | RuntimeError | SyntaxError $exception) {
            echo $exception->getMessage();
        }
    }
}
