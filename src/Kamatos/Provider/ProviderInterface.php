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
    public function register(ContainerInterface $container = null);
}