<?php

namespace App\Repository;

use App\Entity\Card;
use App\Exception\CardNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

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

    public function getById(int $id): Card
    {
        $card = $this->entityManager->getRepository(Card::class)->find($id);
        if ($card == null) {
            throw new CardNotFoundException("Card not found");
        }
        
        return $card;
    }
}
