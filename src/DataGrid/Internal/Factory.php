<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Internal;

use Spiral\AdminPanel\DataGrid\Configurator\ColumnsConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\DefaultsConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\FiltersConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\PaginatorConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\SortersConfigurator;
use Spiral\AdminPanel\DataGrid\GridSchemaInterface;
use Spiral\Core\FactoryInterface as Container;

final class Factory implements FactoryInterface
{
    public function __construct(
        private readonly Container $factory
    ) {
    }

    /**
     * @param non-empty-string $name
     */
    public function create(string $name, GridSchemaInterface $schema): GridSchema
    {
        $instance = new GridSchema(
            name: $name,
            columnsConfigurator: $this->factory->make(ColumnsConfigurator::class),
            filtersConfigurator: $this->factory->make(FiltersConfigurator::class),
            sortersConfigurator: $this->factory->make(SortersConfigurator::class),
            paginatorConfigurator: $this->factory->make(PaginatorConfigurator::class),
            defaultsConfigurator: $this->factory->make(DefaultsConfigurator::class)
        );

        $instance->configure($schema);

        return $instance;
    }
}
