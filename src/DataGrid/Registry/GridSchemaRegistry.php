<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Registry;

use Spiral\AdminPanel\DataGrid\Exception\InvalidArgumentException;
use Spiral\AdminPanel\DataGrid\Internal\GridSchema;

final class GridSchemaRegistry implements GridSchemaRegistryInterface
{
    /**
     * @var array<non-empty-string, GridSchema>
     */
    private array $schemas = [];

    /**
     * @param non-empty-string $name
     */
    public function add(string $name, GridSchema $schema): void
    {
        if ($this->hasGridSchema($name)) {
            throw new InvalidArgumentException(\sprintf('GridSchema with name `%s` already exists.', $name));
        }

        $this->schemas[$name] = $schema;
    }

    /**
     * @param non-empty-string $name
     */
    public function get(string $name): GridSchema
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
