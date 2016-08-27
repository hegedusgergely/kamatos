<?php
namespace Kamatos\Tests\Http\Provider;

use Exception;
use Kamatos\Http\Provider\LoggerProvider;
use Monolog\Logger;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Description of LoggerProviderTest
 *
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class LoggerProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;
    
    public function setUp()
    {
        parent::setUp();
        $structure = [
            'readable_and_writable' => [
                'app.log' => ''
            ]
        ];
        $this->root = vfsStream::create($structure, vfsStream::setup('logs'));
        $this->root->getChild('readable_and_writable')->chmod(0600);
    }
    
    /**
     * @param string $name The provied name.
     * @param mixed $handler The provided handler.
     * @dataProvider dataProviderValidNameAndHandler
     */
    public function testReturnsLoggerInstanceWhenNameAndHandlerIsValid($name, $handler)
    {
        $provider = new LoggerProvider($name, $handler);
        
        $logger = $provider->provide();
        
        $this->assertInstanceOf(Logger::class, $logger);
    }
    
    /**
     * @param string $name The provided name.
     * @param mixed $handler The provided handler.
     * @dataProvider dataProviderValidNameAndHandler
     */
    public function testLoggerNameSetProperly($name, $handler)
    {
        $provider = new LoggerProvider($name, $handler);
        
        $logger = $provider->provide();
        
        $this->assertEquals($name, $logger->getName());
    }
    
    /**
     * @param string $name The provided name.
     * @param mixed $handler The provided handler.
     * @dataProvider dataProviderValidNameAndHandler
     */
    public function testLoggerHasOnlyOneHandler($name, $handler)
    {
        $provider = new LoggerProvider($name, $handler);
        
        $logger = $provider->provide();
        
        $this->assertCount(1, $logger->getHandlers());
    }
    
    public function testLoggerHandlerPathSetProperly()
    {
        $handlerPaths = [
            'handler.log',
            '/path/to/handler.log',
            '../../../relative/path/to/handler.log',
            $this->getHandler()
        ];
        
        foreach ($handlerPaths as $handlerPath) {
            $provider = new LoggerProvider('logger_name', $handlerPath);
            
            $handlers = $provider->provide()->getHandlers();
            
            $this->assertEquals($handlerPath, $handlers[0]->getUrl());
        }
    }
    
    /**
     * @param mixed $handler The provided handler.
     * @expectedException Exception
     * @expectedExceptionMessage The log handler path must be a string or resource!
     * @dataProvider dataProviderInvalidHandler
     */
    public function testThrowsExceptionWhenHandlerIsInvalid($handler)
    {
        $name = 'logger_name';
        
        $provider = new LoggerProvider($name, $handler);
        $provider->provide();
    }
    
    /**
     * @param mixed $name The provided name.
     * @expectedException Exception
     * @expectedExceptionMessage The logger name must be a string!
     * @dataProvider dataProviderInvalidName
     */
    public function testThrowsExceptionWhenNameIsInvalid($name)
    {
        $handler = $this->getHandler();
        
        $provider = new LoggerProvider($name, $handler);
        $provider->provide();
    }
    
    /**
     * Returns the path of handler.
     * 
     * @return string
     */
    private function getHandler()
    {
        return $this->root->getChild('readable_and_writable')->getChild('app.log')->url();
    }
    
    public function dataProviderInvalidHandler()
    {
        return [
            [''],
            [false],
            [0],
            [1.5],
            [[]],
            [new stdClass]
        ];
    }
    
    public function dataProviderInvalidName()
    {
        return [
            [''],
            ['     '],
            ['.!?@#'],
            ['012345'],
            ['1.5'],
            [0],
            [1.5],
            [false],
            [[]],
            [new stdClass],
            ['a'],
            [str_repeat('a', 2)],
            [str_repeat('a', 33)]
        ];
    }
    
    public function dataProviderValidNameAndHandler()
    {
        return [
            ['logger_name', '/path/to/log.file'],
            [str_repeat('a', 3), '../another/path/to/log.file'],
            [str_repeat('a', 32), tmpfile()]
        ];
    }
}
