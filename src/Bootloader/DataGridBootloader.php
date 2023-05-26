<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Bootloader;

use Spiral\AdminPanel\Config\GridConfig;
use Spiral\AdminPanel\DataGrid;
use Spiral\AdminPanel\DataGrid\Configurator;
use Spiral\AdminPanel\DataGrid\Internal\ColumnFactory;
use Spiral\AdminPanel\DataGrid\Internal\ColumnFactoryInterface;
use Spiral\AdminPanel\DataGrid\Internal\Factory;
use Spiral\AdminPanel\DataGrid\Internal\FactoryInterface;
use Spiral\AdminPanel\DataGrid\Registry\GridSchemaRegistry;
use Spiral\AdminPanel\DataGrid\Registry\GridSchemaRegistryInterface;
use Spiral\AdminPanel\DataGrid\Response\GridResponseInterface;
use Spiral\AdminPanel\DataGrid\Response\GridResponse;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Config\Patch\Append;
use Spiral\Core\Container\Autowire;
use Spiral\Core\FactoryInterface as ContainerFactory;
use Spiral\Cycle\DataGrid\Writer\BetweenWriter;
use Spiral\Cycle\DataGrid\Writer\QueryWriter;
use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Grid;
use Spiral\DataGrid\GridFactoryInterface;
use Spiral\DataGrid\GridInput;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\InputInterface;
use Spiral\DataGrid\WriterInterface;

/**
 * @psalm-import-type TWriter from GridConfig
 */
final class DataGridBootloader extends Bootloader
{
    protected const SINGLETONS = [
        ColumnFactoryInterface::class => ColumnFactory::class,
        GridSchemaRegistryInterface::class => GridSchemaRegistry::class,
        FactoryInterface::class => Factory::class,
        InputInterface::class => GridInput::class,
        GridInterface::class => Grid::class,
        GridFactoryInterface::class => GridFactoryInterface::class,
        Compiler::class => [self::class, 'compiler'],
        GridResponseInterface::class => GridResponse::class,
    ];

    protected const BINDINGS = [
        DataGrid\ColumnsConfigurator::class => Configurator\ColumnsConfigurator::class,
        DataGrid\FiltersConfigurator::class => Configurator\FiltersConfigurator::class,
        DataGrid\SortersConfigurator::class => Configurator\SortersConfigurator::class,
        DataGrid\PaginatorConfigurator::class => Configurator\PaginatorConfigurator::class,
        DataGrid\DefaultsConfigurator::class => Configurator\DefaultsConfigurator::class
    ];

    public function __construct(
        private readonly ConfiguratorInterface $config
    ) {
    }

    public function init(): void
    {
        $this->config->setDefaults(GridConfig::CONFIG, [
            'writers' => [
                QueryWriter::class,
                BetweenWriter::class,
            ]
        ]);
    }

    public function compiler(ContainerFactory $factory, Compiler $compiler, GridConfig $config): Compiler
    {
        foreach ($config->getWriters() as $writer) {
            $writer = match (true) {
                \is_string($writer) => $factory->make($writer),
                $writer instanceof Autowire => $writer->resolve($factory),
                default => $writer
            };
            \assert($writer instanceof WriterInterface);

            $compiler->addWriter($writer);
        }

        return $compiler;
    }

    /**
     * @psalm-param TWriter $writer
     */
    public function addWriter(string|WriterInterface|Autowire $writer): void
    {
        $this->config->modify(GridConfig::CONFIG, new Append('writers', null, $writer));
    }
}
