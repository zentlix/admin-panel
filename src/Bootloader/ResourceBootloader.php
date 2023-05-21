<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Bootloader;

use Spiral\AdminPanel\Resource\Resource;
use Spiral\AdminPanel\Resource\ResourceInterface;
use Spiral\Boot\Bootloader\Bootloader;

final class ResourceBootloader extends Bootloader
{
    protected const SINGLETONS = [
        ResourceInterface::class => Resource::class
    ];
}
