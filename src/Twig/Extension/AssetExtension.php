<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Twig\Extension;

use Spiral\AdminPanel\Config\AdminPanelConfig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class AssetExtension extends AbstractExtension
{
    public function __construct(
        private readonly AdminPanelConfig $config
    ) {
    }

    public function getFunctions(): array
    {
        return [new TwigFunction('admin_panel_asset', [$this, 'asset'])];
    }

    /**
     * @param non-empty-string $filename
     *
     * @return non-empty-string
     */
    public function asset(string $filename): string
    {
        $filename = \ltrim($filename, '/');
        $assetPath = \rtrim($this->config->getAssetPath() ?? '', '/');

        return $assetPath . '/' . $filename;
    }
}
