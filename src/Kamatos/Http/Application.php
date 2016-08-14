<?php
namespace Kamatos\Http;

use Kamatos\Provider\ProviderInterface;
use Slim\App as SlimApplication;
use Slim\Exception\ContainerException;

/**
 * Description of Application
 *
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class Application extends SlimApplication
{
    /**
     * {@inheritdoc}
     */
    public function __construct($container = [])
    {
        parent::__construct($container);
    }
    
    public function registerService($name, $callback)
    {
        $container = $this->getContainer();
        
        if ($container->has($name)) {
            throw new ContainerException;
        }
        
        if (is_object($callback) && $callback instanceof ProviderInterface) {
            $container[$name] = $callback->register($container);
        } elseif (is_callable($callback)) {
            $container[$name] = $callback;
        } else {
            throw new ContainerException;
        }
    }
}
