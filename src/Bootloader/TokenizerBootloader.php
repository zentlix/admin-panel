<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Bootloader;

use Psr\Container\ContainerInterface;
use Spiral\AdminPanel\DataGrid\TokenizerListener\GridSchemaListener;
use Spiral\AdminPanel\Menu\SidebarListener;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Tokenizer\Bootloader\TokenizerListenerBootloader;

final class TokenizerBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        TokenizerListenerBootloader::class,
    ];

    public function boot(TokenizerListenerBootloader $tokenizer, ContainerInterface $container): void
    {
        $tokenizer->addListener($container->get(SidebarListener::class));
        $tokenizer->addListener($container->get(GridSchemaListener::class));
    }
}
