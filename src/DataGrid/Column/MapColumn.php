<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

class MapColumn extends TextColumn
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
        'raw' => false,
        'default' => null,
        'map' => []
    ];

    public function normalize(mixed $value): string
    {
        $value = match (true) {
            $value instanceof \BackedEnum => $value->value,
            default => (string) $value
        };

        return parent::normalize($this->options['map'][$value] ?? $this->options['default'] ?? $value);
    }
}
