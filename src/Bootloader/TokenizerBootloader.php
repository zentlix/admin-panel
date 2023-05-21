<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Bootloader;

use Spiral\AdminPanel\Menu\SidebarListener;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Tokenizer\Bootloader\TokenizerListenerBootloader;

final class TokenizerBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        TokenizerListenerBootloader::class,
    ];

    public function boot(TokenizerListenerBootloader $tokenizer, SidebarListener $listener): void
    {
        $tokenizer->addListener($listener);
    }
}
