<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Internal;

use Spiral\AdminPanel\DataGrid\Column\ColumnInterface;
use Spiral\Core\FactoryInterface;

final class ColumnFactory implements ColumnFactoryInterface
{
    public function __construct(
        private readonly FactoryInterface $factory
    ) {
    }

    /**
     * @psalm-param class-string<ColumnInterface> $type
     * @psalm-param non-empty-string $name
     */
    public function make(string $type, string $name, array $options): ColumnInterface
    {
        /** @var ColumnInterface $instance */
        $instance = $this->factory->make($type);
        $instance->initialize($name, $options);

        return $instance;
    }
}
