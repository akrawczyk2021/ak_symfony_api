<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;

class CardRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }

    public function findOneByName(string $name): ?Card
    {
        return $this->entityManager->getRepository(Card::class)->findOneBy(['name' => $name]);
    }
}
