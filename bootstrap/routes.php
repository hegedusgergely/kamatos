<?php

use Kamatos\Http\Controller\CalculationController;

$app->get('/', CalculationController::getActionName('index'))->setName('calculationForm');

$app->post('/', CalculationController::getActionName('calculate'))->setName('calculation');

$app->get('/szamitas-eredmenye', CalculationController::getActionName('result'))->setName('calculationResult');