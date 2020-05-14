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
     * @param array $context
     */
    public function loadTemplateWithContext(string $templateName, array $context): void
    {
        if (!isset($this->twig)) {
            return;
        }

        try {
            echo $this->twig->render($templateName, $context);
        } catch (LoaderError | RuntimeError | SyntaxError $exception) {
            echo $exception->getMessage();
        }
    }
}
