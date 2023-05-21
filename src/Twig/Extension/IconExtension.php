<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Twig\Extension;

use Spiral\Core\FactoryInterface;
use Spiral\Views\ViewsInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class IconExtension extends AbstractExtension
{
    public function __construct(
        private readonly FactoryInterface $factory
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('admin_panel_icon', [$this, 'icon'], ['is_safe' => ['html']])
        ];
    }

    public function icon(string $icon, string $class = '', array $attributes = []): string
    {
        $attrs = [];
        foreach ($attributes as $name => $value) {
            $attrs[] = \is_null($value) ? $name : \sprintf('%s="%s"', $name, $value);
        }

        return $this->factory
            ->make(ViewsInterface::class)
            ->render('admin:icons/' . $icon, ['class' => $class, 'attributes' => \implode(' ', $attrs)]);
    }
}
