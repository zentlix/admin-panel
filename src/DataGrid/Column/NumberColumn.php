<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

class NumberColumn extends AbstractColumn
{
    /**
     * @var array<non-empty-string, mixed>
     */
    protected array $options = [
        'label' => null,
        'field' => null,
        'data' => null,
        'render' => null,
        'visible' => true,
        'raw' => false
    ];

    public function normalize(mixed $value): string
    {
        $value = (string) $value;
        if (\is_numeric($value)) {
            return $value;
        }

        return $this->isRaw() ? $value : (string) (float) $value;
    }

    public function isRaw(): bool
    {
        return $this->options['raw'];
    }
}
