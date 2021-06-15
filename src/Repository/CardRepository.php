<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use App\Request\CreateCard;

class CardRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Card $card): void
    {
        $this->entityManager->persist($card);
    }

    public function findOneByName(string $name): ?Card
    {
        return $this->entityManager->getRepository(Card::class)->findOneBy(['name' => $name]);
    }

    public function createCard(CreateCard $createCard): void
    {
        $card = new Card(
            $createCard->getName(),
            $createCard->getHp(),
            $createCard->getAttack(),
            $createCard->getDefense(),
        );
        $card->setDescription($createCard->getDescription());
        $this->add($card);
    }
}
