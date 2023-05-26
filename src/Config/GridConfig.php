<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Config;

use Spiral\Core\Container\Autowire;
use Spiral\Core\InjectableConfig;
use Spiral\Cycle\DataGrid\Writer\BetweenWriter;
use Spiral\Cycle\DataGrid\Writer\QueryWriter;
use Spiral\DataGrid\WriterInterface;

/**
 * @psalm-type TWriter = WriterInterface|class-string<WriterInterface>|Autowire<WriterInterface>
 *
 * @property array{
 *     writers: TWriter[]
 * } $config
 */
final class GridConfig extends InjectableConfig
{
    public const CONFIG = 'grid';

    protected array $config = [
        'writers' => [
            QueryWriter::class,
            BetweenWriter::class,
        ],
    ];

    /**
     * @return TWriter[]
     */
    public function getWriters(): array
    {
        return $this->config['writers'];
    }
}
