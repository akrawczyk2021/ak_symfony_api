<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Response\UserResponse;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Transformer\SimpleTransformer;
use App\Validator\UserRequestValidator;
use Codeception\Util\HttpCode;
use Exception;
use Phpass\Hash;

class UserController extends AbstractController
{
    private $em;
    private $usersRepository;

    public function __construct(EntityManagerInterface $em, UsersRepository $usersRepository)
    {
        $this->em = $em;
        $this->usersRepository = $usersRepository;
    }

    /**
     * User List
     * @Route("/users",name="users_list",methods={"GET"})
     * 
     */

    public function listUsers(SimpleTransformer $simpletransformer): JsonResponse
    {
        $list=$simpletransformer->transformCollectionToArray($this->usersRepository->findAll());
        return $this->json($list, HttpCode::OK);
    }

    /**
     * User data
     * @Route("/users/{id}",name="users_data",methods={"GET"})
     * 
     */

    public function userDetails(Users $user): JsonResponse
    {
        if ($user!=null) {
            $user=new UserResponse($user->getName(),$user->getEmail(),$user->getPassword());
        }
        return $this->json($user->getDtoAsArray(), HttpCode::OK);
        
    }

    /**
     * Create User
     * @Route("/users",name="users_create",methods={"POST"})
     * 
     */

    public function addUsers(Request $request,SimpleTransformer $transformer,UserRequestValidator $validator): JsonResponse
    {
        $hash=new Hash();
        $requestdata=$transformer->decodeJsonContent($request,$validator);
        if($requestdata!=null)
        {
        try {
                $user = new Users();
                $user->setName($requestdata->getName());
                $user->setEmail($requestdata->getEmail());
                $user->setPassword($hash->hashPassword($requestdata->getPassword()));
                $user->setCreatedate(new DateTime());
                $this->em->persist($user);
                $this->em->flush();
            } catch (Exception $ex) {
                return $this->json($ex->errorInfo, 404);
            }
                return $this->json($requestdata->getDtoAsArray(), HttpCode::CREATED);
        } else {
            throw $this->createNotFoundException("Wrong data format");
        }

    }

    /**
     * Delete User
     * @Route("/users/{id}",name="users_delete",methods={"DELETE"})
     * 
     */

    public function DeleteUsers(Users $user): JsonResponse
    {
        if ($user!=null) {
            $this->em->remove($user);
            $this->em->flush();
            return $this->json(['message' => 'deleted'], HttpCode::OK);
        } else {
            return $this->json(['message' => 'Wrong user ID'], HttpCode::BAD_REQUEST);
        }
        
    }

    /**
     * Update User
     * @Route("/users/{id}",name="users_update",methods={"PUT"})
     * 
     */

    public function UpdateUsers(Users $user, Request $request,SimpleTransformer $transformer,UserRequestValidator $validator)
    {
        $requestdata=$transformer->decodeJsonContent($request,$validator);
               
        if($requestdata!=null)
        {
            $user->setName($requestdata->getName());
            $user->setEmail($requestdata->getEmail());
            $user->setPassword($requestdata->getPassword());
            $this->em->persist($user);
            $this->em->flush();
        } else {
            throw $this->createNotFoundException("Wrong data format");
        }
        return $this->json($requestdata->getDtoAsArray(), HttpCode::OK);
    }
}
