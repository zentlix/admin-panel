<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Configurator;

use Spiral\AdminPanel\DataGrid\ColumnsConfigurator as ColumnsConfiguratorInterface;
use Spiral\AdminPanel\DataGrid\Column\ColumnFactoryInterface;
use Spiral\AdminPanel\DataGrid\Column\ColumnInterface;
use Spiral\AdminPanel\DataGrid\Exception\InvalidArgumentException;

final class ColumnsConfigurator implements ColumnsConfiguratorInterface
{
    /**
     * @var array<non-empty-string, ColumnInterface>
     */
    private array $columns = [];

    public function __construct(
        private readonly ColumnFactoryInterface $factory
    ) {
    }

    /**
     * @param non-empty-string $name
     * @param class-string<ColumnInterface> $type
     */
    public function add(string $name, string $type, array $options): self
    {
        if ($this->hasColumn($name)) {
            throw new InvalidArgumentException(\sprintf('Column with name `%s` already exists.', $name));
        }

        $this->columns[$name] = $this->factory->make($type, $name, $options);

        return $this;
    }

    /**
     * @return array<non-empty-string, ColumnInterface>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param non-empty-string $name
     */
    public function hasColumn(string $name): bool
    {
        return isset($this->columns[$name]);
    }
}
