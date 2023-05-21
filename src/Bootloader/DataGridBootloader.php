<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Bootloader;

use Spiral\AdminPanel\DataGrid;
use Spiral\AdminPanel\DataGrid\Configurator;
use Spiral\AdminPanel\DataGrid\Internal\ColumnFactory;
use Spiral\AdminPanel\DataGrid\Internal\ColumnFactoryInterface;
use Spiral\AdminPanel\DataGrid\Internal\Factory;
use Spiral\AdminPanel\DataGrid\Internal\FactoryInterface;
use Spiral\AdminPanel\DataGrid\Registry\GridSchemaRegistry;
use Spiral\AdminPanel\DataGrid\Registry\GridSchemaRegistryInterface;
use Spiral\Boot\Bootloader\Bootloader;

final class DataGridBootloader extends Bootloader
{
    protected const SINGLETONS = [
        ColumnFactoryInterface::class => ColumnFactory::class,
        GridSchemaRegistryInterface::class => GridSchemaRegistry::class,
        FactoryInterface::class => Factory::class,
    ];

    protected const BINDINGS = [
        DataGrid\ColumnsConfigurator::class => Configurator\ColumnsConfigurator::class,
        DataGrid\FiltersConfigurator::class => Configurator\FiltersConfigurator::class,
        DataGrid\SortersConfigurator::class => Configurator\SortersConfigurator::class,
        DataGrid\PaginatorConfigurator::class => Configurator\PaginatorConfigurator::class,
        DataGrid\DefaultsConfigurator::class => Configurator\DefaultsConfigurator::class
    ];
}
