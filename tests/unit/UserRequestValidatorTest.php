<?php
namespace App\Tests;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserRequestValidatorTest extends \Codeception\Test\Unit
{

    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;
    
    
    protected function _before()
    {
        
    }

    protected function _after()
    {
    }

    // tests
    public function testValidatePassword()
    {
        //$users=$this->make('UsersRepository');
        //$validate=new UserRequestValidator();
        //$validate->isPasswordvalid("test");
        //$this->assertTrue($validate->isPasswordValid("Az1"));
        // $this->expectException($validate->isPasswordvalid("a"));
        // $this->expectException($validate->isPasswordvalid("1"));
        // $this->expectException($validate->isPasswordvalid("Z"));
        // $this->expectException($validate->isPasswordvalid(""));
    }

}