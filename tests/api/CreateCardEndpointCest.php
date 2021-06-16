<?php

namespace App\Tests;

use App\Entity\Card;
use Codeception\Util\HttpCode;

class CreateCardEndpointCest
{
    public function testItCreatesCard(ApiTester $I)
    {
        $I->sendPost(
            '/card',
            [
                'name' => 'Goblin',
                'description' => 'Low level monster',
                'hp' => 10,
                'attack' => 1,
                'defense' => 1,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeInRepository(
            Card::class,
            [
                'name' => 'Goblin',
                'description' => 'Low level monster',
                'hp' => 10,
                'attack' => 1,
                'defense' => 1,
            ]
        );
    }

    /**
     * @dataProvider badRequestTestCaseProvider
     */
    public function testCreateCardWithInvalidData(ApiTester $I, \Codeception\Example $example)
    {
        foreach ($example['existedEntities'] as $entity) {
            $I->haveInRepository($entity);
        }

        $I->sendPost('/card', $example['requestBody']);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    protected function badRequestTestCaseProvider(): array
    {
        return [
            'With duplicated name' => [
                'existedEntities' => [
                    $existedCard = new Card(
                        'Goblin',
                        1,
                        1,
                        1,
                    )
                ],
                'requestBody' => [
                    'name' => $existedCard->getName(),
                    'description' => 'Low level monster',
                    'hp' => 10,
                    'attack' => 1,
                    'defense' => 1,
                ]
            ],
            'With space in name' => [
                'existedEntities' => [],
                'requestBody' => [
                    'name' => "test space",
                    'description' => 'Low level monster',
                    'hp' => 10,
                    'attack' => 1,
                    'defense' => 1,
                ]
            ],
            'With negative value' => [
                'existedEntities' => [],
                'requestBody' => [
                    'name' => "Monster",
                    'description' => 'Low level monster',
                    'hp' => 10,
                    'attack' => -1,
                    'defense' => 1,
                ]
            ],
            'With empty stat value' => [
                'existedEntities' => [],
                'requestBody' => [
                    'name' => "Monster",
                    'description' => 'Low level monster',
                    'hp' => null,
                    'attack' => -1,
                    'defense' => 1,
                ]
            ],
            'With empty name' => [
                'existedEntities' => [],
                'requestBody' => [
                    'name' => "",
                    'description' => 'Low level monster',
                    'hp' => 1,
                    'attack' => 1,
                    'defense' => 1,
                ]
            ],
            'With empty description' => [
                'existedEntities' => [],
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
}
