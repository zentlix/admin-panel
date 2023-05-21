<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

class TextColumn extends AbstractColumn
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

        return $this->isRaw() ? $value : \htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    public function isRaw(): bool
    {
        return $this->options['raw'];
    }
}
