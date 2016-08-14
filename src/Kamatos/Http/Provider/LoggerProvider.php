<?php
namespace Kamatos\Http\Provider;

use Exception;
use Interop\Container\ContainerInterface;
use Kamatos\Provider\ProviderInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Description of LoggerProvider
 *
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class LoggerProvider implements ProviderInterface
{
    public function register(ContainerInterface $container = null)
    {
        $settings = $container->get('settings')->get('logger', [
            'name' => null,
            'handler' => null
        ]);

        if (!isset($settings['name']) || !is_string($settings['name'])) {
            throw new Exception('The logger name must be a string!');
        }
        if (!isset($settings['handler']) || !is_string($settings['handler'])) {
            throw new Exception('The log handler must be provided!');
        }

        $logger = new Logger($settings['name']);
        $logger->pushHandler(new StreamHandler($settings['handler']));
        return $logger;
    }
}