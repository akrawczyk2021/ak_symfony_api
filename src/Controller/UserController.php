<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Users;
use App\Request\CreateUser;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Create User
     * @Route("/users",name="users_create",methods={"POST"})
     * @ParamConverter("createuser", class="App\Request\CreateUser")
     */
    public function addUsers(CreateUser $createuser): Response
    {
        try {
            $user = new Users();
            $user->setName($createuser->getName());
            $user->setEmail($createuser->getEmail());
            $user->setPassword($createuser->getPassword());
            $user->setCreatedate(new DateTime());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $ex) {
            return $this->json($ex->errorInfo, 404);
        }

        return $this->json([], Response::HTTP_CREATED);
    }
}
