<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Configurator;

use Spiral\AdminPanel\DataGrid\Exception\InvalidArgumentException;
use Spiral\DataGrid\Specification\FilterInterface;
use Spiral\AdminPanel\DataGrid\FiltersConfigurator as FiltersConfiguratorInterface;

final class FiltersConfigurator implements FiltersConfiguratorInterface
{
    /**
     * @var array<non-empty-string, FilterInterface>
     */
    private array $filters = [];

    /**
     * @param non-empty-string $name
     */
    public function add(string $name, FilterInterface $filter): self
    {
        if ($this->hasFilter($name)) {
            throw new InvalidArgumentException(\sprintf('Filter with name `%s` already exists.', $name));
        }

        $this->filters[$name] = $filter;

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
     * @return array<non-empty-string, FilterInterface>
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
