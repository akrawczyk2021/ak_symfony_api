<?php

namespace App\Tests;

use App\Entity\Card;
use App\Exception\NotUniqueCardnameException;
use App\Repository\CardRepository;
use App\Validator\CardDataValidator;

class CardDataValidatorTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected UnitTester $tester;
    private CardDataValidator $validator;

    protected function _before()
    {
        $repository = $this->make(CardRepository::class);
        $this->validator = new CardDataValidator($repository);
    }

    /**
     * @param string $name
     * @dataProvider validNameDataProvider
     */
    public function testIsNameValid(string $name)
    {
        $this->assertTrue($this->validator->isValidName($name));
    }

    public function validNameDataProvider(): array
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

    public function testIsNameInvalidWithEmptyData()
    {
        $this->assertFalse($this->validator->isValidName(''));
    }

    /**
     * @param string $description
     * @dataProvider validDescriptionDataProvider
     */
    public function testIsDescriptionValidWithCorrectData(string $description)
    {
        $this->assertTrue($this->validator->isValidDescription($description));
    }

    public function validDescriptionDataProvider(): array
    {
        return [
            'name contains short text' => [
                'name' => 'abcdvds'
            ],
            'contains long text' => [
                'name' => 'abcd123 dsfvdsf43 34t3g rg eerg 543 ggdf gdfg gdfgfd ggfdgdfg dgdfg dfg54 dgfdf'
            ],
        ];
    }

    public function testIsDescriptionInvalidWithEmptyData()
    {
        $this->assertFalse($this->validator->isValidDescription(''));
    }

    /**
     * @param int $value
     * @dataProvider correctStatValuesDataProvider
     */
    public function testIsIntStatValidWithCorrectData(int $value)
    {
        $this->assertTrue($this->validator->isValidIntStat($value));
    }

    public function correctStatValuesDataProvider()
    {
        return [
            'Positive value' => [
                'attack' => 5
            ],
        ];
    }

    /**
     * @param int $value
     * @dataProvider incorrectStatValuesDataProvider
     */
    public function testIsIntStatInvalidWithIncorrectData(int $value)
    {
        $this->assertFalse($this->validator->isValidIntStat($value));
    }

    public function incorrectStatValuesDataProvider()
    {
        return [
            'nagative value' => [
                'attack' => -5
            ],
            'Zero' => [
                'attack' => 0
            ],
        ];
    }

    public function testEnsureItThrowsExceptionWhenNameIsNotUnique()
    {
        $repository = $this->createMock(CardRepository::class);
        $repository->method('findOneByName')->willReturn(new Card($cardName = 'Goblin', 1, 1, 1));
        $validator = new CardDataValidator($repository);

        $this->expectException(NotUniqueCardnameException::class);

        $validator->ensureNameIsUnique($cardName);
    }

    public function testEnsureThatItDoesntThrowExceptionWhenNameIsUnique()
    {
        $repository = $this->createMock(CardRepository::class);
        $repository->method('findOneByName')->willReturn(null);
        $validator = new CardDataValidator($repository);

        $validator->ensureNameIsUnique("Goblin");
        $this->assertTrue(true);
    }
}
