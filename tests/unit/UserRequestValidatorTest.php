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
        $users=$this->createMock(UsersRepository::class);
        $validate=new UserRequestValidator($users);
        $this->assertTrue($validate->isPasswordValid("Az1"));
        
    }

}