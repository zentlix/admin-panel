<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Twig\Extension;

use Spiral\AdminPanel\Config\AdminPanelConfig;
use Spiral\Config\Patch\Traits\DotTrait;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ConfigExtension extends AbstractExtension
{
    use DotTrait;

    public function __construct(
        private readonly AdminPanelConfig $config
    ) {
    }

    public function getFunctions(): array
    {
        return [new TwigFunction('admin_panel_config', [$this, 'config'])];
    }

    public function config(string $name): mixed
    {
        $config = $this->config->toArray();

        return $this->dotGet($config, $name);
    }
}
