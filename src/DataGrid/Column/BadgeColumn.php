<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

use Spiral\AdminPanel\Exception\InvalidArgumentException;
use Spiral\Views\ViewsInterface;

class BadgeColumn extends AbstractColumn
{
    protected const TYPES = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark'
    ];

    /**
     * @var array<non-empty-string, mixed>
     */
    protected array $options = [
        'type' => null,
        'conditions' => [],
        'label' => null,
        'field' => null,
        'data' => null,
        'render' => null,
        'visible' => true,
        'template' => null,
    ];

    public function __construct(
        protected readonly ViewsInterface $views
    ) {
    }

    protected function render(mixed $value, mixed $context): string
    {
        return $this->views->render($this->getTemplate($value), [
            'row' => $context,
            'value' => $value,
        ]);
    }

    public function normalize(mixed $value): mixed
    {
        return $value;
    }

    protected function getTemplate(mixed $value): string
    {
        if ($this->options['conditions'] !== []) {
            return \sprintf('admin:datagrid/column/badge-%s', $this->getFromConditions($value));
        }

        if (\is_string($this->options['type'])) {
            if (!\in_array($this->options['type'], self::TYPES, true)) {
                throw new InvalidArgumentException(\sprintf(
                    'Option `type` must be one of: `%s`.',
                    \implode('`, `', self::TYPES)
                ));
            }

            return \sprintf('admin:datagrid/column/badge-%s', $this->options['type']);
        }

        if (!\is_string($this->options['template']) || empty($this->options['template'])) {
            throw new InvalidArgumentException('Option `template` or `type` is required and must be a string.');
        }

        return $this->options['template'];
    }

    protected function getFromConditions(mixed $value): string
    {
        $value = match (true) {
            $value instanceof \BackedEnum => $value->value,
            \is_bool($value) => $value,
            default => (string) $value
        };

        if (
            !isset($this->options['conditions'][$value]) ||
            !\in_array($this->options['conditions'][$value], self::TYPES, true)
        ) {
            throw new InvalidArgumentException('Option `conditions` is invalid.');
        }

        return $this->options['conditions'][$value];
    }
}
