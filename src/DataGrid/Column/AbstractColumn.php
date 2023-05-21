<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

use Symfony\Component\PropertyAccess\PropertyPathInterface;

abstract class AbstractColumn implements ColumnInterface
{
    /**
     * @var non-empty-string
     */
    private string $name;

    /**
     * @var array<non-empty-string, mixed>
     */
    protected array $options;

    /**
     * @param non-empty-string $name
     * @param array<non-empty-string, mixed>  $options
     */
    public function initialize(string $name, array $options): void
    {
        $this->name = $name;
        $this->options = $options + $this->options;
    }

    /**
     * The transform function is responsible for converting column-appropriate input to a DataGrid-usable type.
     *
     * @param mixed $value The single value of the column, if mapping makes it possible to derive one
     * @param mixed $context All relevant data of the entire row
     */
    public function transform(mixed $value = null, mixed $context = null): mixed
    {
        $data = $this->getData();
        if (\is_callable($data)) {
            $value = $data($context, $value);
        } elseif (null === $value) {
            $value = $data;
        }

        return $this->render($this->normalize($value), $context);
    }

    /**
     * Apply final modifications before rendering to result.
     */
    protected function render(mixed $value, mixed $context): mixed
    {
        if (\is_string($render = $this->options['render'])) {
            return \sprintf($render, $value);
        }

        if (\is_callable($render)) {
            return $render($value, $context);
        }

        return $value;
    }

    /**
     * The normalize function is responsible for converting parsed and processed data to a datatables-appropriate type.
     *
     * @param mixed $value The single value of the column
     */
    abstract public function normalize(mixed $value): mixed;

    /**
     * @return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->options['label'] ?? $this->getName();
    }

    public function getField(): null|string|PropertyPathInterface
    {
        return $this->options['field'];
    }

    public function getData(): mixed
    {
        return $this->options['data'];
    }

    public function isVisible(): bool
    {
        return $this->options['visible'];
    }

    /**
     * @param non-empty-string $name
     */
    public function setOption(string $name, mixed $value): static
    {
        $this->options[$name] = $value;

        return $this;
    }
}
