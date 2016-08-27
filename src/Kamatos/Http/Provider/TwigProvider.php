<?php
namespace Kamatos\Http\Provider;

use Exception;
use Interop\Container\ContainerInterface;
use Kamatos\Provider\ProviderInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/**
 * Description of TwigProvider
 *
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class TwigProvider implements ProviderInterface
{
    /**
     * Path to the templates directory.
     * 
     * @var string
     */
    private $path;
    
    /**
     * Path to the cache directory or false if caching is disabled.
     * 
     * @var string|boolean
     */
    private $cachePath;
    
    /**
     * Instantiates a new TwigProvider object.
     * 
     * @param string $path Path to the templates directory.
     * @param string|boolean $cachePath Path to the cache directory or false if caching is disabled.
     */
    public function __construct($path, $cachePath = false)
    {
        $this->path = $path;
        $this->cachePath = $cachePath;
    }
    
    /**
     * Creates a new Twig object.
     * 
     * @param ContainerInterface|null $container
     * @return Twig
     * @throws Exception
     */
    public function provide(ContainerInterface $container = null)
    {
        $this->validatePath($this->path);
        // Twig environment settings.
        $settings = [
            'debug' => $container->get('settings')->get('displayErrorDetails', false)
        ];
        // If the cache path is not false we validate and store it in the Twig environment settings.
        if (false !== $this->cachePath) {
            $this->validateCachePath($this->cachePath);
            $settings['cache'] = $this->cachePath;
        }
        $view = new Twig($this->path, $settings);
        $view->addExtension(new TwigExtension($container->get('router'), $container->get('request')->getUri()));
        return $view;
    }
    
    /**
     * Returns the path refers to a directory or not.
     * 
     * @param string $directory Path to the directory.
     * @return boolean
     */
    private function isDirectory($directory)
    {
        return is_string($directory) && is_dir($directory);
    }
    
    /**
     * Validates the cache directory path.
     * 
     * @param string $path Cache directory path.
     * @throws Exception
     */
    private function validateCachePath($path)
    {
        if (!$this->isDirectory($path)) {
            throw new Exception('The cache path must be a directory!');
        }
        if (!is_readable($path)) {
            throw new Exception('The cache path must be a readable directory!');
        }
        if (!is_writable($path)) {
            throw new Exception('The cache path must be a writable directory!');
        }
    }
    
    /**
     * Validates the template directory path.
     * 
     * @param string $path Template directory path.
     * @throws Exception
     */
    private function validatePath($path)
    {
        if (!$this->isDirectory($path)) {
            throw new Exception('The view path must be a directory!');
        }
        if (!is_readable($path)) {
            throw new Exception('The view path must be a readable directory!');
        }
    }
}
