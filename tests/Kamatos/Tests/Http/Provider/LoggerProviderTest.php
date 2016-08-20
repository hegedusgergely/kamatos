<?php
namespace Kamatos\Tests\Http\Provider;

use Exception;
use Kamatos\Http\Provider\LoggerProvider;
use Mockery;
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
     * @param mixed $handler The provieded handler.
     * @param boolean $expected The provided expected result.
     * @dataProvider dataProviderIsValidHandler
     */
    public function testIsValidHandlerAcceptsOnlyValidValues($handler, $expected)
    {
        $provider = Mockery::mock(LoggerProvider::class)->makePartial();
        
        $this->assertEquals($expected, $provider->isValidHandler($handler));
    }
    
    /**
     * @param mixed $name The provided name.
     * @param boolean $expected The provided expected result.
     * @dataProvider dataProviderIsValidName
     */
    public function testIsValidNameAcceptsOnlyValidValues($name, $expected)
    {
        $provider = Mockery::mock(LoggerProvider::class)->makePartial();
        
        $this->assertEquals($expected, $provider->isValidName($name));
    }
    
    public function testProvideReturnLoggerInstanceWhenAllArgumentsAreValid()
    {
        $arguments = ['logger_name', 'logger_handler'];
        
        $provider = Mockery::mock(LoggerProvider::class, $arguments);
        
        $provider->shouldReceive('isValidName')->andReturn(true);
        $provider->shouldReceive('isValidHandler')->andReturn(true);
        $provider->shouldReceive('provide')->passthru();
        
        $logger = $provider->provide();
        
        $provider->shouldHaveReceived('isValidName')->once();
        $provider->shouldHaveReceived('isValidHandler')->once();
        
        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertEquals($arguments[0], $logger->getName());
    }
    
    public function testProvideReturnsStreamHandlerInstanceWhenAllArgumentsAreValid()
    {
        $arguments = ['logger_name', 'logger_handler'];
        
        $provider = Mockery::mock(LoggerProvider::class, $arguments);
        
        $provider->shouldReceive('isValidName')->andReturn(true);
        $provider->shouldReceive('isValidHandler')->andReturn(true);
        $provider->shouldReceive('provide')->passthru();
        
        $logger = $provider->provide();
        $handlers = $logger->getHandlers();
        
        $provider->shouldHaveReceived('isValidName')->once();
        $provider->shouldHaveReceived('isValidHandler')->once();
        
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf(StreamHandler::class, $handlers[0]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The log handler path must be a string or resource!
     */
    public function testProvideThrowsExceptionWhenHandlerIsInvalid()
    {
        $provider = Mockery::mock(LoggerProvider::class);
        
        $provider->shouldReceive('isValidName')->andReturn(true);
        $provider->shouldReceive('isValidHandler')->andReturn(false);
        $provider->shouldReceive('provide')->passthru();
        
        $provider->provide();
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage The logger name must be a string!
     */
    public function testProvideThrowsExceptionWhenNameIsInvalid()
    {
        $provider = Mockery::mock(LoggerProvider::class);
        
        $provider->shouldReceive('isValidName')->andReturn(false);
        $provider->shouldReceive('isValidHandler')->andReturn(true);
        $provider->shouldReceive('provide')->passthru();
        
        $provider->provide();
    }
    
    public function dataProviderIsValidHandler()
    {
        return [
            ['', false],
            ['abc', true],
            ['012', true],
            ['path/to/dir', true],
            ['path/to/log.file', true],
            ['../another/path/to/log.file', true],
            [tmpfile(), true],
            [false, false],
            [0, false],
            [1.5, false],
            [[], false],
            [new stdClass, false]
        ];
    }
    
    public function dataProviderIsValidName()
    {
        return [
            ['', false],
            ['     ', false],
            ['.!?@#', false],
            ['012345', false],
            ['1.5', false],
            [0, false],
            [1.5, false],
            [false, false],
            [[], false],
            [new stdClass, false],
            ['logger_name', true],
            ['loggerName', true],
            ['a', false],
            [str_repeat('a', 2), false],
            [str_repeat('a', 3), true],
            [str_repeat('a', 32), true],
            [str_repeat('a', 33), false]
        ];
    }
}
