<?php
declare(strict_types=1);

namespace App\Transformer;

use Doctrine\Common\Collections\Collection;


class SimpleTransformer{

    //UserTransformer
    //Transform collection
    public function transformCollectionToArray(array $users): array{
        $usersList = [];
        foreach ($users as $user) {
            $usersList[] = [             "id" => $user->getId(),             "name" => $user->getName(),              "email" => $user->getEmail(), 
             "createdate" => $user->getCreateDate()];
        }
        return $usersList;
    }

}


//class userdto{
    
  //  public Name;
  //  public email;




//}