<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Users;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
     * 
     */
    public function addUsers(
        Request $request, //DTO
    ): Response {

        if ($request->getContentType() == 'json') {
            try {
                $user = new Users();
                $user->setName($request->get('name'));
                $user->setEmail($request->get('email'));
                $user->setPassword($request->get('password'));
                $user->setCreatedate(new DateTime());
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            } catch (\Exception $ex) {
                return $this->json($ex->errorInfo, 404);
            }
            return $this->json([], Response::HTTP_CREATED);
        } else {
            throw $this->createNotFoundException("Wrong data format");
        }
    }
}
