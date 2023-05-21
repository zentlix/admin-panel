<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

interface ColumnInterface
{
    /**
     * @param non-empty-string $name
     * @param array<non-empty-string, mixed> $options
     */
    public function initialize(string $name, array $options): void;

    /**
     * @return non-empty-string
     */
    public function getName(): string;

    /**
     * @return non-empty-string
     */
    public function getLabel(): string;
}
