<?php

namespace App\Tests\Helper;

use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Codeception\TestInterface;

class Api extends Module
{
    private Module\REST|Module $rest;

    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
        $this->rest = $this->getModule('REST');
    }

    public function _before(TestInterface $test)
    {
        $this->rest->haveHttpHeader('Accept', 'application/json');
        $this->rest->haveHttpHeader('Content-Type', 'application/json');
    }
}
