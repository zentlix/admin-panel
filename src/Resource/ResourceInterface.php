<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Resource;

interface ResourceInterface
{
    public function renderList(\ReflectionMethod $action, ListResource $listResource): string;
    public function renderCreate(\ReflectionMethod $action, CreateResource $createResource): string;
    public function renderUpdate(\ReflectionMethod $action, UpdateResource $updateResource): string;
}
