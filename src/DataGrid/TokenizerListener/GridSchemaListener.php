<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\TokenizerListener;

use Spiral\AdminPanel\Attribute\GridSchema;
use Spiral\AdminPanel\DataGrid\GridSchemaInterface;
use Spiral\AdminPanel\DataGrid\Internal\FactoryInterface;
use Spiral\AdminPanel\DataGrid\Registry\GridSchemaRegistryInterface;
use Spiral\Attributes\ReaderInterface;
use Spiral\Core\FactoryInterface as Container;
use Spiral\Tokenizer\TokenizationListenerInterface;

final class GridSchemaListener implements TokenizationListenerInterface
{
    public function __construct(
        private readonly ReaderInterface $reader,
        private readonly GridSchemaRegistryInterface $registry,
        private readonly FactoryInterface $gridFactory,
        private readonly Container $factory
    ) {
    }

    public function listen(\ReflectionClass $class): void
    {
        $grid = $this->reader->firstClassMetadata($class, GridSchema::class);

        if ($grid !== null) {
            /** @var GridSchemaInterface $gridSchema */
            $gridSchema = $this->factory->make($class->getName());
            $this->registry->add(
                $grid->name,
                $this->gridFactory->create($grid->name, $gridSchema)
            );
        }
    }

    public function finalize(): void
    {
    }
}
