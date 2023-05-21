<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spiral\AdminPanel\Config\AdminPanelConfig;
use Spiral\Auth\Middleware\Firewall\AbstractFirewall;
use Spiral\Http\ResponseWrapper;
use Spiral\Router\RouterInterface;
use Spiral\Session\SessionScope;

final class LoginMiddleware extends AbstractFirewall
{
    public function __construct(
        private readonly ResponseWrapper $response,
        private readonly RouterInterface $router,
        private readonly AdminPanelConfig $config,
        private readonly SessionScope $sessionScope
    ) {
    }

    public function denyAccess(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->sessionScope->getActiveSession()->getSection('auth')->set('target_path', (string) $request->getUri());

        return $this->response->redirect($this->router->uri($this->config->getLoginRoute()), 302);
    }
}
