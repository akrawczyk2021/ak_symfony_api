<?php

namespace App\Controller;

use App\DTOs\UsersDTO;
use App\Entity\Users;
use App\Repository\UsersRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Phpass\Hash;
use App\Transformer\SimpleTransformer;
use App\Validator\UserRequestValidator;
use Codeception\Util\HttpCode;
use PDOException;
use App\Response\UserResponseNoPassword;


class UserController extends AbstractController
{
    private $em;
    private $usersRepository;

    public function __construct(EntityManagerInterface $em, UsersRepository $usersRepository,)
    {
        $this->em = $em;
        $this->usersRepository = $usersRepository;
    }

    /**
     * User List
     * @Route("/users",name="users_list",methods={"GET"})
     * 
     */

    public function ListUsers(SimpleTransformer $simpletransformer): JsonResponse
    {
        
        
        $list=$simpletransformer->transformCollectionToArray($this->usersRepository->findAll());
        //$list = SimpleTransformer::transfomObjectToArray($users);

        return $this->json($list, HttpCode::OK);
    }

    /**
     * User data
     * @Route("/users/{id}",name="users_data",methods={"GET"})
     * 
     */

    public function DataUsers(Users $usersDTO): JsonResponse
    {

        $users = $usersDTO->getName();

        return $this->json($users, HttpCode::OK);
        //new UserResponse(id,name)
    }

    /**
     * Create User
     * @Route("/users",name="users_create",methods={"POST"})
     * 
     */

    public function AddUsers(Request $request): JsonResponse
    {
        $hashlib = new Hash();
        $reqdata = json_decode($request->getContent(), true);
        try {
            $user = new Users();
            $user->setName($reqdata['name']);
            $user->setEmail($reqdata['email']);
            $user->setPassword($hashlib->hashPassword($reqdata['password']));
            $user->setCreatedate(new DateTime());

            $this->em->persist($user);
            $this->em->flush();
        } catch (PDOException $ex) {
            return $this->json($ex->errorInfo, 404);
        }

        return $this->json($reqdata, HttpCode::CREATED);
    }

    /**
     * Delete User
     * @Route("/users/{id}",name="users_delete",methods={"DELETE"})
     * 
     */

    public function DeleteUsers(Users $user): JsonResponse
    {
        $this->em->remove($user);
        $this->em->flush();
        return $this->json(['message' => 'deleted'], HttpCode::ACCEPTED);
    }

    /**
     * Update User
     * @Route("/users/{id}",name="users_update",methods={"PUT"})
     * 
     */

    public function UpdateUsers(Users $user, Request $request,UserRequestValidator $uservalidator): JsonResponse
    {
        $requestdata=$uservalidator->decodeContent($request);
        
        dump($requestdata);
        die();
         if($requestdata!=null){
            $user->setName($requestdata->getName());
            $user->setEmail($requestdata->getEmail());
            $user->setPassword($requestdata->getPassword());
            $this->em->persist($user);
            $this->em->flush();
        }else{
            throw $this->createNotFoundException("Wrong data format1");
        }


        return $this->json($requestdata, HttpCode::OK);
    }
}
