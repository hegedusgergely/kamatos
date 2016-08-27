<?php
namespace Kamatos\Http\Controller;

use Kamatos\Http\Controller\BaseController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Description of CalculationController
 * 
 * @author Balázs Máté Petro <petrobalazsmate@gmail.com>
 */
class CalculationController extends BaseController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->container->get('logger')->addInfo('info');
        
        return $this->container->get('view')->render($response, 'calculation/form.html', [
            'formUrl' => $this->container->router->pathFor('calculation')
        ]);
    }

    public function calculate(ServerRequestInterface $request)
    {
        echo 'calculating...';
    }

    public function result()
    {
        
    }
}