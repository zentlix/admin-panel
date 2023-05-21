<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Configurator;

use Spiral\AdminPanel\DataGrid\PaginatorConfigurator as PaginatorConfiguratorInterface;
use Spiral\DataGrid\Specification\Pagination\PagePaginator;

/**
 * @psalm-suppress MissingConstructor
 */
final class PaginatorConfigurator implements PaginatorConfiguratorInterface
{
    private PagePaginator $paginator;

    /**
     * @var array<array-key, int<0, max>>
     */
    private array $allowedLimits = [];

    /**
     * @param int<0, max> $limit
     * @param array<array-key, int<0, max>> $allowedLimits
     */
    public function configure(int $limit, array $allowedLimits): void
    {
        $this->paginator = new PagePaginator($limit, $allowedLimits);
        $this->allowedLimits = $allowedLimits;
    }

    public function getPaginator(): PagePaginator
    {
        return $this->paginator;
    }

    /**
     * @return array<array-key, int<0, max>>
     */
    public function getAllowedLimits(): array
    {
        return $this->allowedLimits;
    }
}
