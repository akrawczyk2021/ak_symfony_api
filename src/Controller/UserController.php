<?php

namespace App\Controller;

use App\Entity\Users;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use JsonException;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    /**
     * User List
     * @Route("/users",name="users_list",methods={"GET"})
     * 
     */

    public function ListUsers():JsonResponse
    {


        $users = $this->em->getRepository(Users::class)->findAll();

        $list = [];
        foreach ($users as $user) {
            $list[] = array("id" => $user->getId(), "name" => $user->getName(), "email" => $user->getEmail(), "password" => $user->getPassword(),"createdate"=>$user->getCreateDate());
        }

        return $this->json($list, 200);
    }

    /**
     * Create User
     * @Route("/users",name="users_create",methods={"POST"})
     * 
     */

    public function AddUsers(Request $request):JsonResponse
    {
        $reqdata = json_decode($request->getContent(), true);

        $user = new Users();
        $user->setName($reqdata['name']);
        $user->setEmail($reqdata['email']);
        $user->setPassword("Blank");
        $user->setCreatedate(new DateTime());

        $this->em->persist($user);
        $this->em->flush();


        return $this->json($reqdata, 201);
    }

    /**
     * Delete User
     * @Route("/users/{id}",name="users_delete",methods={"DELETE"})
     * 
     */

    public function DeleteUsers($id):JsonResponse
    {

        $user = $this->getDoctrine()->getManager()->getRepository(Users::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException("No data found");
        }
        $this->em->remove($user);
        $this->em->flush();
        return $this->json(['users' => $id], 200);
    }

    /**
     * Update User
     * @Route("/users/{id}",name="users_update",methods={"PUT"})
     * 
     */

    public function UpdateUsers($id, Request $request):JsonResponse
    {

        $reqdata = json_decode($request->getContent(), true);
        $user = $this->em->getRepository(Users::class)->find($id);
        $user = $this->em->getRepository(Users::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException("No data found");
        }
        $user->setName($reqdata['name']);
        $user->setEmail($reqdata['email']);
        $user->setPassword("Blank");

        $this->em->persist($user);
        $this->em->flush();


        return $this->json($reqdata, 200);
    }
}
