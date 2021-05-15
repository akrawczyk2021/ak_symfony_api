<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository 
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email'=>$email]);
    }
}
