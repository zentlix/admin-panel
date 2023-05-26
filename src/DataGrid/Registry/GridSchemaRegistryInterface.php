<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Registry;

interface GridSchemaRegistryInterface
{
    /**
     * @param non-empty-string $name
     * @param class-string $schema
     */
    public function add(string $name, string $schema): void;

    /**
     * @param non-empty-string $name
     *
     * @return class-string
     */
    public function get(string $name): string;
}
