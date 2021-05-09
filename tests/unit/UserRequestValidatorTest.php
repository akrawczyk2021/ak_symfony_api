<?php
namespace App\Tests;

use App\Repository\UsersRepository;
use App\Validator\UserRequestValidator;
use PHPUnit\Framework\MockObject\MockClass;

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
        //$user=$this->make('UsersRepository');
        //$validate=new UserRequestValidator($users);
        //$validate->isPasswordvalid("test");
        //$this->assertTrue($validate->isPasswordValid("Az1"));
        // $this->expectException($validate->isPasswordvalid("a"));
        // $this->expectException($validate->isPasswordvalid("1"));
        // $this->expectException($validate->isPasswordvalid("Z"));
        // $this->expectException($validate->isPasswordvalid(""));
    }

}