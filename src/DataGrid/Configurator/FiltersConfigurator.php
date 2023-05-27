<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Configurator;

use Spiral\DataGrid\Specification\FilterInterface;
use Spiral\AdminPanel\DataGrid\FiltersConfigurator as FiltersConfiguratorInterface;

final class FiltersConfigurator implements FiltersConfiguratorInterface
{
    /**
     * @var array<non-empty-string, array{filter: FilterInterface, label?: non-empty-string, choices?: array}>
     */
    private array $filters = [];

    public function search(FilterInterface $filter): self
    {
        $this->filters['search']['filter'] = $filter;

        return $this;
    }

    /**
     * @param non-empty-string $name
     * @param non-empty-string $label
     */
    public function filter(string $name, FilterInterface $filter, string $label, array $choices): self
    {
        $this->filters[$name]['filter'] = $filter;
        $this->filters[$name]['label'] = $label;
        $this->filters[$name]['choices'] = $choices;

        return $this;
    }

    /**
     * @param non-empty-string $name
     */
    public function hasFilter(string $name): bool
    {
        return isset($this->filters[$name]);
    }

    /**
     * @return array<non-empty-string, array{filter: FilterInterface, label?: non-empty-string, choices?: array}>
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
