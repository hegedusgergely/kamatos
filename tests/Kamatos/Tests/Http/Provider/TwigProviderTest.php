<?php
namespace Kamatos\Tests\Http\Provider;

use Exception;
use Kamatos\Http\Provider\TwigProvider;
use Mockery;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit_Framework_TestCase;
use Slim\Collection;
use Slim\Container;
use Slim\Http\Request;
use Slim\Router;
use Slim\Views\Twig;
use stdClass;
use Twig_Loader_Filesystem;

/**
 * Description of TwigProviderTest
 *
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class TwigProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;
    
    public function setUp()
    {
        parent::setUp();
        $structure = [
            'not_readable' => [],
            'not_writable' => [],
            'readable' => [],
            'readable_and_writable' => []
        ];
        $this->root = vfsStream::create($structure, vfsStream::setup('templates'));
        $this->root->getChild('not_readable')->chmod(0300);
        $this->root->getChild('not_writable')->chmod(0500);
        $this->root->getChild('readable')->chmod(0400);
        $this->root->getChild('readable_and_writable')->chmod(0600);
    }
    
    public function testProvideReturnsTwigInstanceWhenViewPathIsReadableDirectory()
    {
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath);
        
        $container = $this->getMockedContainer();
        
        $twig = $provider->provide($container);
        
        $this->assertInstanceOf(Twig::class, $twig);
    }
    
    public function testTwigInstanceHasFilesystemLoader()
    {
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath);
        
        $container = $this->getMockedContainer();
        
        $twig = $provider->provide($container);
        
        $this->assertInstanceOf(Twig_Loader_Filesystem::class, $twig->getLoader());
    }
    
    public function testFilesystemLoaderHasOnlyTheGivenPath()
    {
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath);
        
        $container = $this->getMockedContainer();
        
        $twig = $provider->provide($container);
        
        $paths = $twig->getLoader()->getPaths();
        
        $this->assertCount(1, $paths);
        $this->assertEquals($viewPath, $paths[0]);
    }
    
    public function testDebugEnvironmentSetProperly()
    {
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath);
        
        $containerInDebugMode = $this->getMockedContainer(['displayErrorDetails' => true]);
        $containerNotInDebugMode = $this->getMockedContainer(['displayErrorDetails' => false]);
        
        $twigInDebugMode = $provider->provide($containerInDebugMode);
        $twigNotInDebugMode = $provider->provide($containerNotInDebugMode);
        
        $this->assertTrue($twigInDebugMode->getEnvironment()->isDebug());
        $this->assertFalse($twigNotInDebugMode->getEnvironment()->isDebug());
    }
    
    public function testCachingIsDisabledWhenCachePathIsFalse()
    {
        $cachePath = false;
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath, $cachePath);
        
        $container = $this->getMockedContainer(['displayErrorDetails' => true]);
        
        $twig = $provider->provide($container);
        
        $this->assertInstanceOf(Twig::class, $twig);
        $this->assertFalse($twig->getEnvironment()->getCache());
    }
    
    public function testFilesystemUsedForCachingWhenCachePathIsReadableAndWritable()
    {
        $cachePath = $this->getCachePath();
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath, $cachePath);
        
        $container = $this->getMockedContainer(['displayErrorDetails' => true]);
        
        $twig = $provider->provide($container);
        
        $this->assertInstanceOf(Twig::class, $twig);
        $this->assertEquals($cachePath, $twig->getEnvironment()->getCache());
    }
    
    public function testHasSlimExtension()
    {
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath);
        
        $container = $this->getMockedContainer();
        
        $twig = $provider->provide($container);
        
        $this->assertTrue($twig->getEnvironment()->hasExtension('slim'));
    }
    
    /**
     * @param mixed $path The provided path.
     * @expectedException Exception
     * @expectedExceptionMessage The view path must be a directory!
     * @dataProvider dataProviderInvalidPath
     */
    public function testThrowsExceptionWhenViewPathIsNotDirectory($path)
    {
        $provider = new TwigProvider($path);
        $provider->provide();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage The view path must be a directory!
     */
    public function testThrowsExceptionWhenViewPathIsNotAnExistingDirectory()
    {
        $path = 'path/to/a/not/existing/directory';
        
        $provider = new TwigProvider($path);
        $provider->provide();
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage The view path must be a readable directory!
     */
    public function testThrowsExceptionWhenViewPathIsNotReadable()
    {
        $path = $this->getDirectoryPath('not_readable');
        
        $provider = new TwigProvider($path);
        $provider->provide();
    }
    
    /**
     * @param mixed $path The provided path.
     * @expectedException Exception
     * @expectedExceptionMessage The cache path must be a directory!
     * @dataProvider dataProviderInvalidPath
     */
    public function testThrowsExceptionWhenCachePathIsNotDirectory($path)
    {   
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath, $path);
        
        $container = $this->getMockedContainer();
        
        $provider->provide($container);
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage The cache path must be a directory!
     */
    public function testThrowsExceptionWhenCachePathIsNotAnExistingDirectory()
    {
        $cachePath = 'path/to/a/not/existing/directory';
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath, $cachePath);
        
        $container = $this->getMockedContainer();
        
        $provider->provide($container);
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage The cache path must be a readable directory!
     */
    public function testThrowsExceptionWhenCachePathIsNotReadable()
    {
        $cachePath = $this->getDirectoryPath('not_readable');
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath, $cachePath);
        
        $container = $this->getMockedContainer();
        
        $provider->provide($container);
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage The cache path must be a writable directory!
     */
    public function testThrowsExceptionWhenCachePathIsNotWritable()
    {
        $cachePath = $this->getDirectoryPath('not_writable');
        $viewPath = $this->getViewPath();
        
        $provider = new TwigProvider($viewPath, $cachePath);
        
        $container = $this->getMockedContainer();
        
        $provider->provide($container);
    }
    
    /**
     * Returns the path of the given directory.
     * 
     * @param string $directory The name of the directory.
     * @return string
     */
    private function getDirectoryPath($directory)
    {
        return $this->root->getChild($directory)->url();
    }
    
    /**
     * Returns the cache path.
     * 
     * @return string
     */
    private function getCachePath()
    {
        return $this->getDirectoryPath('readable_and_writable');
    }
    
    /**
     * Returns the view path.
     * 
     * @return string.
     */
    private function getViewPath()
    {
        return $this->getDirectoryPath('readable');
    }
    
    /**
     * Returns a mocked Container instance.
     * 
     * @param array $settings Configuration for the settings service.
     * @return Mockery
     */
    private function getMockedContainer(array $settings = [])
    {
        $mock = Mockery::mock(Container::class);
        $mock->shouldReceive('get')->with('request')->andReturn($this->getMockedRequest());
        $mock->shouldReceive('get')->with('router')->andReturn($this->getMockedRouter());
        $mock->shouldReceive('get')->with('settings')->andReturn(new Collection($settings));
        return $mock;
    }
    
    /**
     * Returns a mocked Request instance.
     * 
     * @return Mockery
     */
    private function getMockedRequest()
    {
        $mock = Mockery::mock(Request::class);
        $mock->shouldReceive('getUri')->andReturn('request-uri');
        return $mock;
    }
    
    /**
     * Returns a mocked Router instance.
     * 
     * @return Mockery
     */
    private function getMockedRouter()
    {
        return Mockery::mock(Router::class)->makePartial();
    }
    
    public function dataProviderInvalidPath()
    {
        return [
            [0],
            [1.5],
            [true],
            [[]],
            [new stdClass],
            [function() { return 1; }]
        ];
    }
}
