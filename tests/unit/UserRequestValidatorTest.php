<?php

namespace App\Tests;

use App\Repository\UsersRepository;
use App\Validator\UserDataValidator;
use PHPUnit\Framework\MockObject\MockClass;

class UserRequestValidatorTest extends \Codeception\Test\Unit
{

    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;
    private $validator;

    protected function _before()
    {
        $this->validator = new UserDataValidator();
    }

    protected function _after()
    {
    }

    // tests
    public function testValidatePassword()
    {
        $this->assertTrue($this->validator->isValidPassword("Az1"));
        $this->assertFalse($this->validator->isValidPassword("zzzz"));
        $this->assertFalse($this->validator->isValidPassword(""));
    }

    public function testValidateEmail()
    {
        $this->assertTrue($this->validator->isValidEmail("zzzz"));
        $this->assertFalse($this->validator->isValidEmail(""));
    }

    public function testValidateName()
    {
        $this->assertTrue($this->validator->isValidName("zzzz"));
        $this->assertFalse($this->validator->isValidName(""));
    }
}
