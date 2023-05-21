<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

use Spiral\Translator\TranslatorInterface;

class BoolColumn extends AbstractColumn
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
        'trueValue' => 'true',
        'falseValue' => 'false',
        'nullValue' => 'null'
    ];

    public function __construct(
        protected readonly TranslatorInterface $translator
    ) {
    }

    public function normalize($value): string
    {
        if (null === $value) {
            return $this->getNullValue();
        }

        return ((bool) $value) ? $this->getTrueValue() : $this->getFalseValue();
    }

    public function getTrueValue(): string
    {
        return $this->translator->trans($this->options['trueValue']);
    }

    public function getFalseValue(): string
    {
        return $this->translator->trans($this->options['falseValue']);
    }

    public function getNullValue(): string
    {
        return $this->translator->trans($this->options['nullValue']);
    }
}
