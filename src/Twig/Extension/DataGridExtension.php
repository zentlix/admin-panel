<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Twig\Extension;

use Spiral\AdminPanel\DataGrid\Column\ColumnInterface;
use Spiral\AdminPanel\DataGrid\GridSchema;
use Spiral\AdminPanel\DataGrid\Registry\GridSchemaRegistryInterface;
use Spiral\Core\FactoryInterface;
use Spiral\Translator\TranslatorInterface;
use Spiral\Views\ViewsInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class DataGridExtension extends AbstractExtension
{
    public function __construct(
        private readonly FactoryInterface $factory
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('dataGrid', $this->getDataGrid(...), ['is_safe' => ['html']]),
        ];
    }

    public function getDataGrid(string $name, string $url, array $gridOptions = []): string
    {
        $grid = $this->factory->make(GridSchemaRegistryInterface::class)->get($name);
        $gridOptions += $this->getGridOptions($grid);

        return $this->factory
            ->make(ViewsInterface::class)
            ->render('admin:datagrid/datagrid.twig', [
                'grid' => $grid,
                'url' => $url,
                'gridOptions' => \json_encode($gridOptions, JSON_THROW_ON_ERROR)
            ]);
    }

    private function getGridOptions(GridSchema $grid): array
    {
        return [
            'captureForms' => [],
            'captureFilters' => [],
            'namespace' => '',
            'method' => 'post',
            'ui' => [],
            'paginator' => [
                'limitOptions' => $grid->getAllowedLimits()
            ],
            'responsive' => [
                'listSummaryColumn' => '',
                'listExcludeColumns' => [],
                'tableExcludeColumns' => [],
                'listClass' => 'd-md-none',
                'tableClass' => 'table d-none d-md-table'
            ],
            'sort' => $grid->getDefaults()['sort'] ?? '',
            'columns' => \iterator_to_array($this->getColumns($grid->getColumns())),
            'renderers' => [
                'cells' => \iterator_to_array($this->getCellsRenderers($grid->getColumns())),
            ]
        ];
    }

    /**
     * @param ColumnInterface[] $columns
     */
    private function getColumns(array $columns): \Traversable
    {
        $translator = $this->factory->make(TranslatorInterface::class);

        foreach ($columns as $column) {
            yield [
                'id' => $column->getName(),
                'title' => $translator->trans($column->getLabel())
            ];
        }
    }

    /**
     * @param ColumnInterface[] $columns
     */
    private function getCellsRenderers(array $columns): \Traversable
    {
        foreach ($columns as $column) {
            yield $column->getName() => [
                'name' => 'html',
                'arguments' => []
            ];
        }
    }
}
