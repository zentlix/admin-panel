<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Configurator;

use Spiral\AdminPanel\DataGrid\DefaultsConfigurator as DefaultsConfiguratorInterface;

final class DefaultsConfigurator implements DefaultsConfiguratorInterface
{
    /**
     * @var array{
     *     sort?: array<non-empty-string, non-empty-string>
     * }
     */
    private array $defaults = [];

    /**
     * @param array{sort: array<non-empty-string, non-empty-string>} $defaults
     */
    public function configure(array $defaults): void
    {
        $this->defaults = $defaults;
    }

    /**
     * @return array{sort?: array<non-empty-string, non-empty-string>}
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }
}
