<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

use Spiral\AdminPanel\DataGrid\Exception\InvalidArgumentException;
use Spiral\Router\RouterInterface;
use Spiral\Views\ViewsInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\PropertyPathInterface;

class LinkColumn extends ViewColumn
{
    protected PropertyAccessorInterface $accessor;

    public function __construct(
        ViewsInterface $views,
        protected readonly RouterInterface $router,
        ?PropertyAccessorInterface $accessor = null
    ) {
        parent::__construct($views);

        $this->accessor = $accessor ?? PropertyAccess::createPropertyAccessor();
    }

    /**
     * @var array<non-empty-string, mixed>
     */
    protected array $options = [
        'field' => null,
        'label' => null,
        'href' => null,
        'route' => null,
        'routeParameters' => null,
        'visible' => true,
        'title' => '',
        'class' => '',
        'template' => 'admin:datagrid/column/link'
    ];

    protected function render(mixed $value, mixed $context): string
    {
        if (empty($this->options['href']) && empty($this->options['route'])) {
            throw new InvalidArgumentException('Options `href` or `route` is required and must be a string.');
        }

        $href = $this->options['href'];
        if (empty($href)) {
            $href = (string) $this->router->uri(
                $this->options['route'],
                $this->prepareRouteParameters($this->options['routeParameters'], $context)
            );
        }

        return $this->views->render($this->getTemplate(), [
            'href' => $href,
            'title' => $this->options['title'],
            'class' => $this->options['class'],
            'data' => $value
        ]);
    }

    private function prepareRouteParameters(array $parameters, mixed $context): array
    {
        $result = [];
        foreach ($parameters as $name => $value) {
            $result[$name] = (string) $this->getValueFromContext($value, $context);
        }

        return $result;
    }

    private function getValueFromContext(mixed $value, mixed $context): mixed
    {
        if (!\is_array($context) && !\is_object($context)) {
            return $value;
        }

        if (
            $value instanceof PropertyPathInterface ||
            (\str_starts_with($value, '{') && \str_ends_with($value, '}'))
        ) {
            return $this->accessor->getValue(
                $context,
                \is_string($value) ? \trim($value, '{}') : $value
            );
        }

        return $value;
    }
}
