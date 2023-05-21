<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Resource\Interceptor;

use Spiral\AdminPanel\Resource\CreateResource;
use Spiral\AdminPanel\Resource\ListResource;
use Spiral\AdminPanel\Resource\ResourceInterface;
use Spiral\AdminPanel\Resource\ResourceResponse;
use Spiral\AdminPanel\Resource\UpdateResource;
use Spiral\Core\CoreInterceptorInterface;
use Spiral\Core\CoreInterface;

final class ResourceInterceptor implements CoreInterceptorInterface
{
    public function __construct(
        private readonly ResourceInterface $resource
    ) {
    }

    /**
     * @param class-string $controller
     * @param non-empty-string $action
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @throws \Throwable
     */
    public function process(string $controller, string $action, array $parameters, CoreInterface $core): mixed
    {
        $result = $core->callAction($controller, $action, $parameters);

        if (!$result instanceof ResourceResponse) {
            return $result;
        }

        $ref = new \ReflectionMethod($controller, $action);

        return match (true) {
            $result instanceof ListResource => $this->resource->renderList($ref, $result),
            $result instanceof CreateResource => $this->resource->renderCreate($ref, $result),
            $result instanceof UpdateResource => $this->resource->renderUpdate($ref, $result),
            default => $result
        };
    }
}
