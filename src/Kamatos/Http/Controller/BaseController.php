<?php
namespace Kamatos\Http\Controller;

use Interop\Container\ContainerInterface;

/**
 * Description of BaseController
 * 
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
abstract class BaseController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getActionName($action)
    {
        return static::class . ':' . $action;
    }
}
