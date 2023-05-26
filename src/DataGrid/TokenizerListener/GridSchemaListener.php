<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\TokenizerListener;

use Spiral\AdminPanel\Attribute\GridSchema;
use Spiral\AdminPanel\DataGrid\Registry\GridSchemaRegistryInterface;
use Spiral\Attributes\ReaderInterface;
use Spiral\Tokenizer\TokenizationListenerInterface;

final class GridSchemaListener implements TokenizationListenerInterface
{
    public function __construct(
        private readonly ReaderInterface $reader,
        private readonly GridSchemaRegistryInterface $registry
    ) {
    }

    public function listen(\ReflectionClass $class): void
    {
        $grid = $this->reader->firstClassMetadata($class, GridSchema::class);

        if ($grid !== null) {
            $this->registry->add($grid->name, $class->getName());
        }
    }

    public function finalize(): void
    {
    }
}
