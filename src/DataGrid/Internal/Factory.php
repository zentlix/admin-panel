<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Internal;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\AdminPanel\DataGrid\Configurator\ColumnsConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\DefaultsConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\FiltersConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\PaginatorConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\SortersConfigurator;
use Spiral\AdminPanel\DataGrid\GridSchemaInterface;

final class Factory implements FactoryInterface
{
    public function __construct(
        private readonly ContainerInterface $container
    ) {
    }

    /**
     * @param non-empty-string $name
     */
    public function create(string $name, GridSchemaInterface $schema): GridSchema
    {
        $instance = new GridSchema(
            name: $name,
            columnsConfigurator: $this->container->get(ColumnsConfigurator::class),
            filtersConfigurator: $this->container->get(FiltersConfigurator::class),
            sortersConfigurator: $this->container->get(SortersConfigurator::class),
            paginatorConfigurator: $this->container->get(PaginatorConfigurator::class),
            defaultsConfigurator: $this->container->get(DefaultsConfigurator::class),
            dispatcher: $this->container->has(EventDispatcherInterface::class)
                ? $this->container->get(EventDispatcherInterface::class)
                : null
        );

        $instance->configure($schema);

        return $instance;
    }
}
