<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Twig\Extension;

use Spiral\AdminPanel\Session\Flash\FlashBagInterface;
use Spiral\Core\FactoryInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class FlashesExtension extends AbstractExtension
{
    public function __construct(
        private readonly FactoryInterface $factory
    ) {
    }

    public function getFunctions(): array
    {
        return [new TwigFunction('flashes', [$this, 'flashes'])];
    }

    /**
     * @param non-empty-string $type
     */
    public function flashes(string $type): array
    {
        $flashes = $this->factory->make(FlashBagInterface::class);

        $messages = [];
        foreach ($flashes->get($type) as $message) {
            $messages[] = (string) $message;
        }

        return $messages;
    }
}
