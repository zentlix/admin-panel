<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Configurator;

use Spiral\AdminPanel\DataGrid\Exception\InvalidArgumentException;
use Spiral\AdminPanel\DataGrid\SortersConfigurator as SortersConfiguratorInterface;
use Spiral\DataGrid\Specification\SorterInterface;

final class SortersConfigurator implements SortersConfiguratorInterface
{
    /**
     * @var array<non-empty-string, SorterInterface>
     */
    private array $sorters = [];

    /**
     * @param non-empty-string $name
     */
    public function add(string $name, SorterInterface $sorter): self
    {
        if ($this->hasSorter($name)) {
            throw new InvalidArgumentException(\sprintf('Sorter with name `%s` already exists.', $name));
        }

        $this->sorters[$name] = $sorter;

        return $this;
    }

    /**
     * @return array<non-empty-string, SorterInterface>
     */
    public function getSorters(): array
    {
        return $this->sorters;
    }

    /**
     * @param non-empty-string $name
     */
    public function hasSorter(string $name): bool
    {
        return isset($this->sorters[$name]);
    }
}
