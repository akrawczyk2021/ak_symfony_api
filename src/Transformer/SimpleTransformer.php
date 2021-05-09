<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Response\UserResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Validator\UserRequestValidator;


class SimpleTransformer
{

    public function transformCollectionToArray(array $users): array
    {
        $usersList = [];
        foreach ($users as $user) {
            $usersList[] = [
                "id" => $user->getId(),             
                "name" => $user->getName(),              
                "email" => $user->getEmail(),
                "createdate" => $user->getCreateDate()
            ];
        }
        return $usersList;
    }

    public function decodeJsonContent(Request $request, UserRequestValidator $validator): ?UserResponse
    {

        if ($validator->isJsonRequestTypeValid($request))
        {
            $datarequest = json_decode($request->getContent(), true);
            if($validator->isJsonParamsValid($datarequest)
                && $validator->isPasswordValid($datarequest['password']))
                {
                    return new UserResponse($datarequest['name'], $datarequest['email'], $datarequest['password']);
                }
        } 

        return null;
    }
}
