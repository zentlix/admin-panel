<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Registry;

use Spiral\AdminPanel\DataGrid\Exception\InvalidArgumentException;

final class GridSchemaRegistry implements GridSchemaRegistryInterface
{
    /**
     * @var array<non-empty-string, class-string>
     */
    private array $schemas = [];

    /**
     * @param non-empty-string $name
     * @param class-string $schema
     */
    public function add(string $name, string $schema): void
    {
        if ($this->hasGridSchema($name)) {
            throw new InvalidArgumentException(\sprintf('GridSchema with name `%s` already exists.', $name));
        }

        $this->schemas[$name] = $schema;
    }

    /**
     * @param non-empty-string $name
     *
     * @return class-string
     */
    public function get(string $name): string
    {
        if (!$this->hasGridSchema($name)) {
            throw new InvalidArgumentException(\sprintf('GridSchema with name `%s` is not exists.', $name));
        }

        return $this->schemas[$name];
    }

    /**
     * @param non-empty-string $name
     */
    public function hasGridSchema(string $name): bool
    {
        return isset($this->schemas[$name]);
    }
}
