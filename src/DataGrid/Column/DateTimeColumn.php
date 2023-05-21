<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

use Spiral\AdminPanel\DataGrid\Exception\InvalidArgumentException;

class DateTimeColumn extends AbstractColumn
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
        'nullValue' => '',
        'createFromFormat' => null,
        'format' => 'c'
    ];

    /**
     * @throws \Exception
     */
    public function normalize(mixed $value): mixed
    {
        if (null === $value) {
            return $this->options['nullValue'];
        }

        if (!$value instanceof \DateTimeInterface) {
            if (\is_string($this->options['createFromFormat'])) {
                $value = \DateTime::createFromFormat($this->options['createFromFormat'], (string) $value);
                if (false === $value) {
                    $errors = \DateTime::getLastErrors();
                    throw new InvalidArgumentException(implode(', ', $errors['errors'] ?: $errors['warnings']));
                }
            } else {
                $value = new \DateTime((string) $value);
            }
        }

        return $value->format($this->options['format']);
    }
}
