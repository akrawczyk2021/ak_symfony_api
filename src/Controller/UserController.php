<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Request\CreateUser;
use App\Request\ShowUser;
use App\Transformer\SimpleUserListTransformer;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordEncoderInterface $encoder;
    private UserRepository $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $encoder,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
    }

    /**
     * Create User
     * @Route("/user",name="users_create",methods={"POST"})
     */
    public function addUser(CreateUser $createuser): Response
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
            throw new BadRequestException("Database insert error");
        }

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * Show User
     * @Route("/user/{id}",name="user_show",methods={"GET"})
     */
    public function showUser(ShowUser $showUser): Response
    {
        $users = ['users' => $showUser];

        return $this->json($users, Response::HTTP_ACCEPTED);
    }

    /**
     * Show User List
     * @Route("/user",name="user_list",methods={"GET"})
     */
    public function showUserList(SimpleUserListTransformer $transformer): Response
    {
        $list = $transformer->transformCollectionToArray($this->userRepository->findAllIdNameOnly());

        return $this->json($list, Response::HTTP_ACCEPTED);
    }
}
