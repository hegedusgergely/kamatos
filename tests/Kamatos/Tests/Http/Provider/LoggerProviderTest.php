<?php
namespace Kamatos\Tests\Http\Provider;

use Exception;
use Kamatos\Http\Provider\LoggerProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
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
     * @param string $name The provied name.
     * @dataProvider dataProviderValidName
     */
    public function testProvideReturnLoggerInstanceWhenNameIsValid($name)
    {
        $loggerProvider = new LoggerProvider($name, tmpfile());
        
        $logger = $loggerProvider->provide();
        
        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertEquals($name, $logger->getName());
    }
    
    /**
     * @param string|resource $handler The provided handler.
     * @dataProvider dataProviderValidHandler
     */
    public function testProviderReturnsStreamHandlerInstanceWhenHandlerIsValid($handler)
    {
        $loggerProvider = new LoggerProvider('logger_name', $handler);
        
        $logger = $loggerProvider->provide();
        $handlers = $logger->getHandlers();
        
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf(StreamHandler::class, $handlers[0]);
    }
    
    /**
     * @param mixed $handler The provided handler.
     * @expectedException Exception
     * @expectedExceptionMessage The log handler path must be a valid string or resource!
     * @dataProvider dataProviderInvalidHandler
     */
    public function testProvideThrowsExceptionWhenHandlerIsInvalid($handler)
    {
        new LoggerProvider('logger_name', $handler);
    }
    
    /**
     * @param mixed $name The provided name.
     * @expectedException Exception
     * @expectedExceptionMessage The logger name must be a valid string!
     * @dataProvider dataProviderInvalidName
     */
    public function testProvideThrowsExceptionWhenNameIsNotAValidString($name)
    {
        new LoggerProvider($name, '');
    }
    
    public function dataProviderValidName()
    {
        return [
            ['logger_name'],
            ['loggerName'],
            ['abc'],
            [str_repeat('a', 32)]
        ];
    }
    
    public function dataProviderValidHandler()
    {
        return [
            ['handlerName'],
            ['handler_name'],
            [tmpfile()]
        ];
    }
    
    public function dataProviderInvalidHandler()
    {
        return [
            [''],
            [0],
            [false],
            [[]],
            [new stdClass]
        ];
    }
    
    public function dataProviderInvalidName()
    {
        return [
            [''],
            ['     '],
            ['012345'],
            ['.!?@#'],
            ['a'],
            ['ab'],
            [str_repeat('a', 33)],
            [0],
            [false],
            [[]],
            [new stdClass]
        ];
    }
}