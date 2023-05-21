<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Resource;

use Spiral\Views\ViewsInterface;

final class Resource implements ResourceInterface
{
    public function __construct(
        private readonly ViewsInterface $views
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

        $parameters = [
            'title' => $listResource->title,
            'grid' => $listResource->grid,
            'gridRoute' => $listResource->gridRoute,
            'breadcrumbs' => $listResource->breadcrumbs
        ];

        return $this->views->render($listResource->template, \array_merge($parameters, $listResource->parameters));
    }

    public function renderCreate(\ReflectionMethod $action, CreateResource $createResource): string
    {
        $parameters = [];

        return $this->views->render($createResource->template, \array_merge($parameters, $createResource->parameters));
    }

    public function renderUpdate(\ReflectionMethod $action, UpdateResource $updateResource): string
    {
        $parameters = [];

        return $this->views->render($updateResource->template, \array_merge($parameters, $updateResource->parameters));
    }
}
