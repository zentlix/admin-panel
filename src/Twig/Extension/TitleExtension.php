<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Twig\Extension;

use Spiral\AdminPanel\Config\AdminPanelConfig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TitleExtension extends AbstractExtension
{
    public function __construct(
        private readonly AdminPanelConfig $config
    ) {
    }

    public function getFunctions(): array
    {
        return [new TwigFunction('admin_panel_title', [$this, 'title'])];
    }

    /**
     * @param non-empty-string $title
     */
    public function title(string $title): string
    {
        return \str_replace(
            ['{title}', '{brand}'],
            [$title, $this->config->getBrand()],
            $this->config->getTitleFormat()
        );
    }
}
