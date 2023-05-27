<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Internal;

use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\AdminPanel\DataGrid\Column\AbstractColumn;
use Spiral\AdminPanel\DataGrid\Column\ColumnInterface;
use Spiral\AdminPanel\DataGrid\Configurator\ColumnsConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\DefaultsConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\FiltersConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\PaginatorConfigurator;
use Spiral\AdminPanel\DataGrid\Configurator\SortersConfigurator;
use Spiral\AdminPanel\DataGrid\Event\OnConfigureColumns;
use Spiral\AdminPanel\DataGrid\Event\OnConfigureDefaults;
use Spiral\AdminPanel\DataGrid\Event\OnConfigureFilters;
use Spiral\AdminPanel\DataGrid\Event\OnConfigurePaginator;
use Spiral\AdminPanel\DataGrid\Event\OnConfigureSorters;
use Spiral\AdminPanel\DataGrid\Exception\InvalidArgumentException;
use Spiral\AdminPanel\DataGrid\GridSchemaInterface;
use Spiral\DataGrid\GridSchema as DataGridGridSchema;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class GridSchema extends DataGridGridSchema
{
    protected PropertyAccessorInterface $accessor;

    /**
     * @param non-empty-string $name
     */
    public function __construct(
        protected readonly string $name,
        protected readonly ColumnsConfigurator $columnsConfigurator,
        protected readonly FiltersConfigurator $filtersConfigurator,
        protected readonly SortersConfigurator $sortersConfigurator,
        protected readonly PaginatorConfigurator $paginatorConfigurator,
        protected readonly DefaultsConfigurator $defaultsConfigurator,
        protected readonly ?EventDispatcherInterface $dispatcher = null
    ) {
        $this->accessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableMagicMethods()
            ->getPropertyAccessor();
    }

    public function configure(GridSchemaInterface $grid): void
    {
        $grid->columns($this->columnsConfigurator);
        $this->dispatcher?->dispatch(new OnConfigureColumns($this->columnsConfigurator, $grid));

        $grid->filters($this->filtersConfigurator);
        $this->dispatcher?->dispatch(new OnConfigureFilters($this->filtersConfigurator, $grid));

        $grid->sorters($this->sortersConfigurator);
        $this->dispatcher?->dispatch(new OnConfigureSorters($this->sortersConfigurator, $grid));

        $grid->paginator($this->paginatorConfigurator);
        $this->dispatcher?->dispatch(new OnConfigurePaginator($this->paginatorConfigurator, $grid));

        $grid->defaults($this->defaultsConfigurator);
        $this->dispatcher?->dispatch(new OnConfigureDefaults($this->defaultsConfigurator, $grid));

        foreach ($this->filtersConfigurator->getFilters() as $name => $filter) {
            $this->addFilter($name, $filter['filter']);
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
     * @param non-empty-string $name
     */
    public function getFilterChoices(string $name): array
    {
        if (!$this->hasFilter($name)) {
            throw new InvalidArgumentException(\sprintf('Filter with name `%s` not found.', $name));
        }

        return $this->filtersConfigurator->getFilters()[$name]['choices'] ?? [];
    }

    /**
     * @param non-empty-string $name
     *
     * @return non-empty-string
     */
    public function getFilterLabel(string $name): string
    {
        if (!$this->hasFilter($name)) {
            throw new InvalidArgumentException(\sprintf('Filter with name `%s` not found.', $name));
        }

        $label = $this->filtersConfigurator->getFilters()[$name]['label'] ?? '';

        if (empty($label)) {
            throw new InvalidArgumentException('Filter label cannot be empty.');
        }

        return $label;
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
