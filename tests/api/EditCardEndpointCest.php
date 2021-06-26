<?php

namespace App\Tests;

use App\Entity\Card;
use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class EditCardEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    public function testItEditCardWithValidData(ApiTester $I)
    {
        $cardId = $I->haveInDatabase('Card', [
            'name' => 'Goblin',
            'description' => 'Low LVL Monster',
            'attack' => 1,
            'defense' => 1,
            'hp' => 1
        ]);

        $I->sendPut(
            '/card/' . $cardId,
            [
                'name' => 'Goblin',
                'description' => 'High level monster',
                'hp' => 10,
                'attack' => 10,
                'defense' => 10
            ]
        );
        $I->seeInRepository(Card::class, [
            'name' => 'Goblin',
            'description' => 'High level monster',
            'hp' => 10,
            'attack' => 10,
            'defense' => 10
        ]);

        $I->dontSeeInRepository(Card::class, [
            'name' => 'Goblin',
            'description' => 'Low LVL Monster',
            'attack' => 1,
            'defense' => 1,
            'hp' => 1
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }


    /**
     * @dataProvider badRequestTestCaseProvider
     */
    public function testItEditCardWithInvalidData(ApiTester $I, \Codeception\Example $example)
    {
        foreach ($example['existedEntities'] as $entity) {
            $cardId = $I->haveInRepository($entity);
        }

        $I->sendPut('/card/' . $cardId, $example['requestBody']);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    protected function badRequestTestCaseProvider(): array
    {
        return [
            'With space in name' => [
                'existedEntities' => [
                    $existedCard = new Card(
                        'Goblin',
                        1,
                        1,
                        1,
                    )
                ],
                'requestBody' => [
                    'name' => "test space",
                    'description' => 'Low level monster',
                    'hp' => 10,
                    'attack' => 1,
                    'defense' => 1,
                ]
            ],
            'With negative value' => [
                'existedEntities' => [
                    $existedCard = new Card(
                        'Goblin',
                        1,
                        1,
                        1,
                    )
                ],
                'requestBody' => [
                    'name' => "Monster",
                    'description' => 'Low level monster',
                    'hp' => 10,
                    'attack' => -1,
                    'defense' => 1,
                ]
            ],
            'With empty stat value' => [
                'existedEntities' => [
                    $existedCard = new Card(
                        'Goblin',
                        1,
                        1,
                        1,
                    )
                ],
                'requestBody' => [
                    'name' => "Monster",
                    'description' => 'Low level monster',
                    'hp' => null,
                    'attack' => -1,
                    'defense' => 1,
                ]
            ],
            'With empty name' => [
                'existedEntities' => [
                    $existedCard = new Card(
                        'Goblin',
                        1,
                        1,
                        1,
                    )
                ],
                'requestBody' => [
                    'name' => "",
                    'description' => 'Low level monster',
                    'hp' => 1,
                    'attack' => 1,
                    'defense' => 1,
                ]
            ],
            'With empty description' => [
                'existedEntities' => [
                    $existedCard = new Card(
                        'Goblin',
                        1,
                        1,
                        1,
                    )
                ],
                'requestBody' => [
                    'name' => "Monster",
                    'description' => '',
                    'hp' => 1,
                    'attack' => 1,
                    'defense' => 1,
                ]
            ]
        ];
    }

    public function testItThrowsExceptionWithNonUniqueName(ApiTester $I)
    {
        $I->haveInDatabase('Card', [
            'name' => 'Troll',
            'description' => 'High LVL Monster',
            'attack' => 11,
            'defense' => 19,
            'hp' => 15
        ]);

        $cardId = $I->haveInDatabase('Card', [
            'name' => 'Goblin',
            'description' => 'Low LVL Monster',
            'attack' => 1,
            'defense' => 1,
            'hp' => 1
        ]);

        $I->sendPut(
            '/card/' . $cardId,
            [
                'name' => 'Troll',
                'description' => 'High level monster',
                'hp' => '',
                'attack' => 10,
                'defense' => 10
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function testItThrowsExceptionWithNonExistingId(ApiTester $I)
    {
        $cardId = $I->haveInDatabase('Card', [
            'name' => 'Goblin',
            'description' => 'Low LVL Monster',
            'attack' => 1,
            'defense' => 1,
            'hp' => 1
        ]);

        $I->sendPut(
            '/card/' . $cardId + 2123,
            [
                'name' => 'Troll',
                'description' => 'High level monster',
                'hp' => '',
                'attack' => 10,
                'defense' => 10
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
