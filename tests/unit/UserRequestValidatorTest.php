<?php

namespace App\Tests;

use App\Validator\UserDataValidator;
use Codeception\Test\Unit;

class UserRequestValidatorTest extends Unit
{

    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    /**
     * @var UserDataValidator
     */
    private $validator;

    protected function _before()
    {
        $this->validator = new UserDataValidator();
    }

    public function testIsPasswordValid()
    {
        $this->assertTrue($this->validator->isValidPassword("Az1"));
    }

    public function testItInvalidPasswordWithOnlySmallLetters()
    {
        $this->assertFalse($this->validator->isValidPassword("zzzz"));
    }

    public function testIsInvalidPasswordWithEmptyString()
    {
        $this->assertFalse($this->validator->isValidPassword(""));
    }

    public function testIsEmailValid()
    {
        $this->assertTrue($this->validator->isValidEmail("test@test.pl"));
    }

    public function testIsEmailInvalidwithEmptyString()
    {
        $this->assertFalse($this->validator->isValidEmail(""));
    }

    public function testIsValidName()
    {
        $this->assertTrue($this->validator->isValidName("zzzz"));
    }

    public function testIsNameInvalidWithEmptyString()
    {
        $this->assertFalse($this->validator->isValidName(""));
    }
}
