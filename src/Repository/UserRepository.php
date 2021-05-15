<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findOneByEmail(string $email)
    {
        return $this->getEntityManager()
            ->createQuery("select u from App:User u where u.email=:email")
            ->setParameter('email', $email)
            ->getResult();
    }
}
