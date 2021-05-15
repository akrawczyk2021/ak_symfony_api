<?php

namespace App\Tests;

use App\Validator\UserDataValidator;

class UserRequestValidatorTest extends \Codeception\Test\Unit
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

    public function testValidPassword()
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

    public function testValidateEmail()
    {
        $this->assertTrue($this->validator->isValidEmail("zzzz"));
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
