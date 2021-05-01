<?php

namespace App\Controller;

use App\Entity\Users;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Types\DateTimeType;
use Exception;


class UserController extends AbstractController
{
    
    /**
     * User List
     * @Route("/users",name="users_list",methods={"GET"})
     * 
     */

    public function ListUsers(){

        
        $users=$this->getDoctrine()->getManager()->getRepository(Users::class)->findAll();
        
        return $this->json($list,200);
        
    }

    /**
     * Create User
     * @Route("/users",name="users_create",methods={"POST"})
     * 
     */

    public function AddUsers(Request $request){
        $dane=json_decode($request->getContent(),true);
        $user=new Users();
        $user->setName($dane['name']);
        $user->setEmail($dane['email']);
        $user->setPassword("Blank");
        $user->setCreatedate(new DateTime());
        
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        

        return $this->json($dane,201);
    }

    /**
     * Delete User
     * @Route("/users/{id}",name="users_delete",methods={"DELETE"})
     * 
     */

    public function DeleteUsers($id){
        
        $user=$this->getDoctrine()->getManager()->getRepository(Users::class)->find($id);
        if(!$user){
            throw new Exception("No data found");
        }
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(['users'=>$id],200);
    }

    /**
     * Update User
     * @Route("/users/{id}",name="users_update",methods={"PUT"})
     * 
     */

    public function UpdateUsers($id,Request $request){

        $dane=json_decode($request->getContent(),true);
        $user=$this->getDoctrine()->getManager()->getRepository(Users::class)->find($id);
        $user=$this->getDoctrine()->getManager()->getRepository(Users::class)->find($id);
        if(!$user){
            throw new Exception("No data found");
        }
        $user->setName($dane['name']);
        $user->setEmail($dane['email']);
        $user->setPassword("Blank");
        //$user->setCreatedate(new DateTime());
        
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        

        return $this->json($dane,201);
    }


}


?>