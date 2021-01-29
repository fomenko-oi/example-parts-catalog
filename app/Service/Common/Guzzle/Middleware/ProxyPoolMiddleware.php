<?php

declare(strict_types=1);

namespace App\Service\Common\Guzzle\Middleware;

use App\Service\Proxy\Manager\ProxyManagerInterface;
use Illuminate\Log\Logger;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class ProxyPoolMiddleware
{
    /**
     * @var string|null
     */
    private $currentProxy = null;
    /**
     * @var LoggerInterface|null
     */
    private $logger = null;
    /**
     * @var ProxyManagerInterface
     */
    private $proxyManager;

    /**
     * @param callable $nextHandler Next handler to invoke.
     */
    public function __construct(callable $nextHandler, ProxyManagerInterface $proxyManager)
    {
        $this->nextHandler = $nextHandler;
        $this->proxyManager = $proxyManager;
    }

    /**
     * @return \Closure
     */
    public static function create(ProxyManagerInterface $proxyManager, ?LoggerInterface $logger = null)
    {
        return function ($handler) use($proxyManager, $logger) {
            return (new static($handler, $proxyManager))->setLogger($logger);
        };
    }

    public function setLogger(?LoggerInterface $logger = null): self
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @return \Psr\Http\Message\RequestInterface
     */
    public function __invoke(RequestInterface $request, array $options = [])
    {
        $next = $this->nextHandler;

        $options['proxy'] = $this->resolveProxy();

        return $next($request, $options)
            ->then(
                function (ResponseInterface $response) use ($request, $options) {
                    if ($response->getStatusCode() === 429 || $response->getStatusCode() === 403) {
                        if($response->getStatusCode() === 403) {
                            $this->log("Status 429, to many requests: {$this->currentProxy}.");
                        } else {
                            $this->log("Status 429, to many requests: {$this->currentProxy}.");
                        }

                        return $this($request, $options);
                    }

                    $this->log("Success response, {$response->getStatusCode()}, {$this->currentProxy}, {$request->getUri()}");
                    return $response;
                },
                function(\Exception $e) use($request, $options) {
                    $this->log($e->getMessage());
                    return $this($request, $options);
                }
            );
    }

    protected function nextProxy(): void
    {
        $this->currentProxy = $this->proxyManager->next();
    }

    protected function resolveProxy(): string
    {
        $this->currentProxy = $this->proxyManager->next();
        return $this->currentProxy;
    }

    protected function log(string $message): void
    {
        if(!$this->logger) {
            return;
        }

        echo("{$this->currentProxy}: {$message}" . PHP_EOL);

        //$this->logger->log($level, "{$this->currentProxy}: {$message}");
    }
}

