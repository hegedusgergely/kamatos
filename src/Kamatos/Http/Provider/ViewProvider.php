<?php
namespace Kamatos\Http\Provider;

use Exception;
use Interop\Container\ContainerInterface;
use Kamatos\Provider\ProviderInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/**
 * Description of ViewProvider
 *
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class ViewProvider implements ProviderInterface
{
    public function register(ContainerInterface $container = null)
    {
        $settings = $container->get('settings')->get('view', [
            'cache_enabled' => false,
            'cache_path' => null,
            'path' => null
        ]);

        $path = isset($settings['path']) ? $settings['path'] : null;

        if (empty($path)) {
            throw new Exception('The view path must be provided!');
        }
        if (!is_dir($path)) {
            throw new Exception('The view path must be a directory!');
        }
        if (!is_writable($path)) {
            throw new Exception('The view path must be writable!');
        }

        $view = new Twig($path, []);
        $view->addExtension(new TwigExtension($container->get('router'), $container->get('request')->getUri()));
        return $view;
    }
}