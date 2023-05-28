<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

use Spiral\AdminPanel\Exception\InvalidArgumentException;
use Spiral\Views\ViewsInterface;

class ViewColumn extends AbstractColumn
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
        'template' => null,
    ];

    public function __construct(
        protected readonly ViewsInterface $views
    ) {
    }

    protected function render(mixed $value, mixed $context): string
    {
        return $this->views->render($this->getTemplate(), [
            'row' => $context,
            'value' => $value,
        ]);
    }

    public function normalize(mixed $value): mixed
    {
        return $value;
    }

    protected function getTemplate(): string
    {
        if (!\is_string($this->options['template']) || empty($this->options['template'])) {
            throw new InvalidArgumentException('Option `template` is required and must be a string.');
        }

        return $this->options['template'];
    }
}
