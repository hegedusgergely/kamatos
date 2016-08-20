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
    /**
     * The name of the logger.
     * 
     * @var string
     */
    private $name;
    
    /**
     * Path to the logger handler or the resource.
     * 
     * @var string|resource
     */
    private $handler;
    
    /**
     * Instantiates a new LoggerProvider object.
     * 
     * @param string $name The name of the logger.
     * @param string|resource $handler Path to the logger handler or a resource.
     */
    public function __construct($name, $handler)
    {
        $this->name = $name;
        $this->handler = $handler;
    }
    
    /**
     * Creates a logger service.
     * 
     * @param ContainerInterface|null $container
     * @return Logger
     * @throws Exception
     */
    public function provide(ContainerInterface $container = null)
    {
        if (!$this->isValidName($this->name)) {
            throw new Exception('The logger name must be a string!');
        }
        if (!$this->isValidHandler($this->handler)) {            
            throw new Exception('The log handler path must be a string or resource!');
        }
        $logger = new Logger($this->name);
        $logger->pushHandler(new StreamHandler($this->handler));
        return $logger;
    }
    
    /**
     * Validates the name of the logger.
     * 
     * @param string $name Name of the logger.
     * @return boolean
     */
    public function isValidName($name)
    {
        return is_string($name) && preg_match('/^[a-zA-Z_-]{3,32}$/', $name);
    }
    
    /**
     * Validates the logger handler.
     * 
     * @param string|resource $handler The logger handler.
     * @return boolean
     */
    public function isValidHandler($handler)
    {
        return is_resource($handler) || (is_string($handler) && !empty($handler));
    }
}
