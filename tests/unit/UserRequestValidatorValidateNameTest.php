<?php

namespace App\Tests;

use App\Validator\UserDataValidator;
use Codeception\Test\Unit;

class UserRequestValidatorValidateNameTest extends Unit
{
    protected UnitTester $tester;

    /**
     * @param string $name
     * @dataProvider correctNameDataProvider
     */
    public function testValidName(string $name): void
    {
        $validator = new UserDataValidator();

        $result = $validator->isValidName($name);

        $this->assertTrue($result);
    }

    public function correctNameDataProvider(): array
    {
        return [
            'name contains 4 chars' => [
                'name' => 'abcd'
            ],
            'contains 4 small letters and numbers' => [
                'name' => 'abcd123'
            ],
            'uppercase first letter' => [
                'name' => 'Asd123'
            ],
        ];
    }

    /**
     * @param string $name
     * @dataProvider invalidNameProvider
     */
    public function testInvalidName(string $name): void
    {
        $validator = new UserDataValidator();

        $result = $validator->isValidName($name);

        $this->assertFalse($result);
    }

    public function invalidNameProvider(): array
    {
        return [
            'empty name' => [
                'name' => ''
            ],
            'with space' => [
                'name' => 'asd asd'
            ],
            'with 3 spaces' => [
                'name' => 'asd   asd'
            ],
            'name contain special char' => [
                'name' => 'asd   asd'
            ],
        ];
    }
}
