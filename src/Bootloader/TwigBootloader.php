<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Bootloader;

use Spiral\AdminPanel\Twig\Extension\AssetExtension;
use Spiral\AdminPanel\Twig\Extension\ConfigExtension;
use Spiral\AdminPanel\Twig\Extension\DataGridExtension;
use Spiral\AdminPanel\Twig\Extension\IconExtension;
use Spiral\AdminPanel\Twig\Extension\TitleExtension;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\DirectoriesInterface;
use Spiral\Twig\Bootloader\TwigBootloader as TwigBridge;
use Spiral\Views\Bootloader\ViewsBootloader;
use Zentlix\TwigExtensions\Bootloader\ExtensionsBootloader;

final class TwigBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        TwigBridge::class,
        ExtensionsBootloader::class,
    ];

    public function init(ViewsBootloader $views, DirectoriesInterface $dirs, TwigBridge $twig): void
    {
        $views->addDirectory('admin', rtrim($dirs->get('vendor'), '/').'/zentlix/admin-panel/views');

        $twig->addExtension(ConfigExtension::class);
        $twig->addExtension(AssetExtension::class);
        $twig->addExtension(TitleExtension::class);
        $twig->addExtension(IconExtension::class);
        $twig->addExtension(DataGridExtension::class);
    }
}
