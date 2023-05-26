<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Interceptor;

use Psr\Container\ContainerInterface;
use Spiral\AdminPanel\Attribute\DataGrid;
use Spiral\AdminPanel\DataGrid\GridSchemaInterface;
use Spiral\AdminPanel\DataGrid\Internal\FactoryInterface;
use Spiral\AdminPanel\DataGrid\Internal\GridSchema;
use Spiral\AdminPanel\DataGrid\Registry\GridSchemaRegistryInterface;
use Spiral\AdminPanel\DataGrid\Response\GridResponseInterface;
use Spiral\Attributes\ReaderInterface;
use Spiral\Core\CoreInterceptorInterface;
use Spiral\Core\CoreInterface;
use Spiral\DataGrid\GridFactory;

final class GridInterceptor implements CoreInterceptorInterface
{
    /**
     * @var array<non-empty-string, GridSchema>
     */
    private array $grids = [];

    public function __construct(
        private readonly GridSchemaRegistryInterface $registry,
        private readonly GridResponseInterface $response,
        private readonly ContainerInterface $container,
        private readonly GridFactory $gridFactory,
        private readonly FactoryInterface $factory,
        private readonly ReaderInterface $reader
    ) {
    }

    /**
     * @param class-string $controller
     * @param non-empty-string $action
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function process(string $controller, string $action, array $parameters, CoreInterface $core): mixed
    {
        /** @var mixed $result */
        $result = $core->callAction($controller, $action, $parameters);

        if (\is_iterable($result)) {
            $schema = $this->gridSchema($controller, $action);
            if ($schema === null) {
                return $result;
            }

            $grid = $this->gridFactory->create($result, $schema);
            $grid = $grid->withView($schema);

            return $this->response->withGrid($grid);
        }

        return $result;
    }

    /**
     * @param class-string $controller
     * @param non-empty-string $action
     */
    private function gridSchema(string $controller, string $action): ?GridSchema
    {
        $key = \sprintf('%s:%s', $controller, $action);

        if (isset($this->grids[$key])) {
            return $this->grids[$key];
        }

        try {
            $method = new \ReflectionMethod($controller, $action);
        } catch (\ReflectionException) {
            return null;
        }

        /** @var null|DataGrid $attr */
        $attr = $this->reader->firstFunctionMetadata($method, DataGrid::class);
        if ($attr === null) {
            return null;
        }

        /** @var class-string $gridSchemaClass */
        $gridSchemaClass = $this->registry->get($attr->name);
        $gridSchema = $this->container->get($gridSchemaClass);
        \assert($gridSchema instanceof GridSchemaInterface);

        return $this->grids[$key] = $this->factory->create($attr->name, $gridSchema);
    }
}
