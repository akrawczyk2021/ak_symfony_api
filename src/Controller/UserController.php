<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Request\CreateUser;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    /**
     * Create User
     * @Route("/users",name="users_create",methods={"POST"})
     * @ParamConverter("createuser", class="App\Request\CreateUser")
     */
    public function addUsers(CreateUser $createuser): Response
    {
        try {
            $user = new User();
            $user->setName($createuser->getName());
            $user->setEmail($createuser->getEmail());
            $user->setPassword($this->encoder->encodePassword($user, $createuser->getPassword()));
            $user->setCreatedate(new DateTime());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $ex) {
            return $this->json($ex->errorInfo, 404);
        }

        return $this->json([], Response::HTTP_CREATED);
    }

    /** 
     * Show User
     */
    public function showUser(): Response
    {
        return $this->json([]);
    }
}
