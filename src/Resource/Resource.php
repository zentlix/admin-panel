<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Resource;

use Knp\Menu\Provider\MenuProviderInterface;
use Knp\Menu\Twig\Helper;
use Spiral\AdminPanel\Exception\InvalidArgumentException;
use Spiral\Views\ViewsInterface;

final class Resource implements ResourceInterface
{
    public function __construct(
        private readonly ViewsInterface $views,
        private readonly Helper $helper,
        private readonly MenuProviderInterface $menuProvider
    ) {
    }

    public function renderList(\ReflectionMethod $action, ListResource $listResource): string
    {
        if ($listResource->gridRoute === null) {
            $listResource->gridRoute = $action->getShortName() . '.grid';
        }
        if ($listResource->grid === null) {
            $listResource->grid = $action->getShortName() . '.grid';
        }

        return $this->views->render($listResource->template, ['resource' => $listResource]);
    }

    public function renderCreate(\ReflectionMethod $action, CreateResource $createResource): string
    {
        return $this->views->render($createResource->template, ['resource' => $createResource]);
    }

    public function renderUpdate(\ReflectionMethod $action, UpdateResource $updateResource): string
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if (!isset($updateResource->redirectTo)) {
            $updateResource->redirectTo = $this->getParentResourceUri();
        }

        return $this->views->render($updateResource->template, ['resource' => $updateResource]);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getParentResourceUri(): string
    {
        $item = $this->helper->getCurrentItem($this->menuProvider->get('admin_panel.sidebar'));
        if ($item === null) {
            throw new InvalidArgumentException(\sprintf('Please provide the `redirectTo` parameter.'));
        }

        $parent = $item->getParent() or throw new InvalidArgumentException(
            'Failed to determine the parent resource. Please provide the `redirectTo` parameter.'
        );
        $uri = $parent->getUri();
        if ($uri === null) {
            throw new InvalidArgumentException(
                'Failed to determine the parent resource. Please provide the `redirectTo` parameter.'
            );
        }

        return $uri;
    }
}
