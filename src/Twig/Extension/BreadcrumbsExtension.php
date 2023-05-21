<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Twig\Extension;

use Knp\Menu\Provider\MenuProviderInterface;
use Knp\Menu\Twig\Helper;
use Spiral\Core\FactoryInterface;
use Spiral\Views\ViewsInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class BreadcrumbsExtension extends AbstractExtension
{
    public function __construct(
        private readonly FactoryInterface $factory
    ) {
    }

    public function getFunctions(): array
    {
        return [new TwigFunction('admin_panel_breadcrumbs', [$this, 'breadcrumbs'], ['is_safe' => ['html']])];
    }

    public function breadcrumbs(array $breadcrumbs = []): string
    {
        $helper = $this->factory->make(Helper::class);
        $registry = $this->factory->make(MenuProviderInterface::class);

        if ($breadcrumbs === []) {
            $item = $helper->getCurrentItem($registry->get('admin_panel.sidebar'));
            if ($item !== null) {
                $breadcrumbs = $helper->getBreadcrumbsArray($item);
            }
        }

        return $this->factory
            ->make(ViewsInterface::class)
            ->render('admin:layout/breadcrumbs', ['breadcrumbs' => $breadcrumbs]);
    }
}
