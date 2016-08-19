<?php
namespace Kamatos\Provider;

use Interop\Container\ContainerInterface;

/**
 * Description of ProviderInterface
 * 
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
interface ProviderInterface
{
    /**
     * Returns the provided service object.
     * 
     * @param ContainerInterface|null $container The container object.
     * @return object The service object.
     */
    public function provide(ContainerInterface $container = null);
}