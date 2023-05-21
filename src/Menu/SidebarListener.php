<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Menu;

use Psr\Container\ContainerInterface;
use Spiral\AdminPanel\Attribute\AsSidebar;
use Spiral\Attributes\ReaderInterface;
use Spiral\KnpMenu\MenuInterface;
use Spiral\KnpMenu\MenuRegistry;
use Spiral\Tokenizer\TokenizationListenerInterface;

final class SidebarListener implements TokenizationListenerInterface
{
    public function __construct(
        private readonly ReaderInterface $reader,
        private readonly MenuRegistry $registry,
        private readonly ContainerInterface $container
    ) {
    }

    public function listen(\ReflectionClass $class): void
    {
        $attr = $this->reader->firstClassMetadata($class, AsSidebar::class);

        if ($attr !== null && !$this->registry->has('admin_panel.sidebar')) {
            $menu = $this->container->get($class->getName());

            \assert($menu instanceof MenuInterface);

            $this->registry->add('admin_panel.sidebar', $menu);
        }
    }

    public function finalize(): void
    {
    }
}
