<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function find(int $id): User
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw new UsernameNotFoundException("User not found");
        } else {
            return $user;
        }
    }

    public function findAllIdNameOnly(): ?array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }
}
