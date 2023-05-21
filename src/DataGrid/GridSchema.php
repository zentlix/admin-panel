<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

use Spiral\AdminPanel\DataGrid\Column\AbstractColumn;
use Spiral\AdminPanel\DataGrid\Column\ColumnInterface;
use Spiral\AdminPanel\DataGrid\Configurator\ColumnsConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\DefaultsConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\FiltersConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\PaginatorConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\SortersConfigurator;
use Spiral\DataGrid\GridSchema as DataGridGridSchema;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class GridSchema extends DataGridGridSchema
{
    protected PropertyAccessor $accessor;

    /**
     * @param non-empty-string $name
     */
    public function __construct(
        protected readonly string $name,
        protected readonly ColumnsConfigurator $columnsConfigurator,
        protected readonly FiltersConfigurator $filtersConfigurator,
        protected readonly SortersConfigurator $sortersConfigurator,
        protected readonly PaginatorConfigurator $paginatorConfigurator,
        protected readonly DefaultsConfigurator $defaultsConfigurator
    ) {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function configure(GridSchemaInterface $grid): void
    {
        $grid->columns($this->columnsConfigurator);
        $grid->filters($this->filtersConfigurator);
        $grid->sorters($this->sortersConfigurator);
        $grid->paginator($this->paginatorConfigurator);
        $grid->defaults($this->defaultsConfigurator);

        foreach ($this->filtersConfigurator->getFilters() as $name => $filter) {
            $this->addFilter($name, $filter);
        }

        foreach ($this->sortersConfigurator->getSorters() as $name => $sorter) {
            $this->addSorter($name, $sorter);
        }

        $this->setPaginator($this->paginatorConfigurator->getPaginator());
    }

    /**
     * @return array<non-empty-string, ColumnInterface>
     */
    public function getColumns(): array
    {
        return $this->columnsConfigurator->getColumns();
    }

    public function getDefaults(): array
    {
        return $this->defaultsConfigurator->getDefaults();
    }

    /**
     * @return array<array-key, int<0, max>>
     */
    public function getAllowedLimits(): array
    {
        return $this->paginatorConfigurator->getAllowedLimits();
    }

    /**
     * @return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __invoke(object|array $data): array
    {
        $row = [];
        /** @var AbstractColumn $column */
        foreach ($this->getColumns() as $column) {
            $field = $column->getField() ?? $column->getName();

            $value = $this->accessor->isReadable($data, $field) ? $this->accessor->getValue($data, $field) : null;
            $row[$column->getName()] = $column->transform($value, $data);
        }

        return $row;
    }
}
