<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

interface GridSchemaInterface
{
    public function columns(ColumnsConfigurator $grid): void;
    public function filters(FiltersConfigurator $grid): void;
    public function sorters(SortersConfigurator $grid): void;
    public function paginator(PaginatorConfigurator $grid): void;
    public function defaults(DefaultsConfigurator $grid): void;
}
