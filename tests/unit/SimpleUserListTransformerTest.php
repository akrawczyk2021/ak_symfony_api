<?php

namespace App\Tests;

use App\Entity\User;
use App\Transformer\SimpleUserListTransformer;
use Exception;

class SimpleUserListTransformerTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;
    private array $userCollection;
    private SimpleUserListTransformer $transformer;

    protected function _before()
    {
        $this->userCollection = [];
        $user1 = new User();
        $user1->setName("Test1");
        $user2 = new User();
        $user2->setName("Test2");
        $this->userCollection[] = $user1;
        $this->userCollection[] = $user2;
        $this->transformer = new SimpleUserListTransformer();
    }

    public function testItReturnsArray()
    {
        $this->tester->assertIsArray($this->transformer->transformCollectionToArray($this->userCollection));
    }

    public function testItReturnsTwoElements()
    {
        $this->tester->assertCount(2, $this->transformer->transformCollectionToArray($this->userCollection));
    }

    public function testItReturnsArrayWithProperKey()
    {
        $this->tester->assertArrayHasKey('1', $this->transformer->transformCollectionToArray($this->userCollection));
    }

    public function testItThrowsExceptionWhenInvalidInput()
    {
        $this->tester->expectThrowable(new Exception("Input data is not a valid User Class"), function () {
            $this->transformer->transformCollectionToArray(['a']);
        });
    }
}
