<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Bootloader;

use Spiral\AdminPanel\Config\AdminPanelConfig;
use Spiral\AdminPanel\Session\Flash\FlashBag;
use Spiral\AdminPanel\Session\Flash\FlashBagInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Core\Container;
use Spiral\AdminPanel\Security\Authenticator;
use Spiral\AdminPanel\Security\AuthenticatorInterface;
use Spiral\AdminPanel\Security\PasswordHasher;
use Spiral\AdminPanel\Security\PasswordHasherInterface;
use Spiral\KnpMenu\Bootloader\KnpMenuBootloader;
use Spiral\Symfony\Form\Bootloader\FormBootloader;
use Spiral\Symfony\Form\Bootloader\TwigBootloader as FormTwigBootloader;

final class AdminPanelBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        DataGridBootloader::class,
        TokenizerBootloader::class,
        TwigBootloader::class,
        FormBootloader::class,
        FormTwigBootloader::class,
        KnpMenuBootloader::class,
    ];

    protected const SINGLETONS = [
        FlashBagInterface::class => FlashBag::class,
    ];

    public function __construct(
        private readonly ConfiguratorInterface $config
    ) {
    }

    public function init(): void
    {
        $this->initDefaultConfig();
    }

    public function boot(Container $container, AdminPanelConfig $config): void
    {
        $container->bindSingleton(AuthenticatorInterface::class, $config->getAuthenticator());
        $container->bindSingleton(PasswordHasherInterface::class, $config->getPasswordHasher());
    }

    private function initDefaultConfig(): void
    {
        $this->config->setDefaults(
            AdminPanelConfig::CONFIG,
            [
                'asset_path' => null,
                'auth_transport' => 'cookie',
                'authenticator' => Authenticator::class,
                'password_hasher' => PasswordHasher::class,
                'dashboard_route' => 'admin.dashboard',
                'login_route' => 'admin.login',
                'google_fonts' => 'https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap',
                'favicon' => null,
                'brand' => 'Spiral Framework',
                'brand_logo' => '<svg viewBox="0 0 294 382" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#6FB7F1" d="M229 57.5L64.7 250.1 23.1 108.6 229 57.5"/>
                                    <path fill="#459AE1" d="M229 57.5l-.3 120.5-56.4 24.8-107.6 47.3z"/>
                                    <path fill="#3F87D2" d="M271.9 7.1L228.7 178l.3-120.5z"/>
                                    <path fill="#6FB7F1" d="M215.6 230l-.3 1.3-29.8 117.6-38-56.3z"/>
                                    <path fill="#3F87D2" d="M172.3 202.8l-24.8 89.8-82.8-42.5z"/>
                                    <path fill="#459AE1" d="M215.6 230l-68.1 62.6 24.8-89.8z"/>
                                </svg>',
                'layout' => [
                    'sidebar' => [
                        'template' => 'admin:layout/sidebar.twig'
                    ],
                ],
                'datagrid' => [
                    'search' => 'Search',
                    'search_placeholder' => 'Search...'
                ],
                'styles' => [
                    'admin/keeper/keeper.css',
                    'admin/app.css',
                    'admin/toastr/toastr.min.css'
                ],
                'scripts' => [
                    'admin/toolkit/ie11.js',
                    'admin/keeper/keeper.js',
                    'admin/toolkit/toolkit.js',
                    'admin/jquery/jquery.min.js',
                    'admin/toastr/toastr.min.js'
                ],
                'script_data' => []
            ]
        );
    }
}
