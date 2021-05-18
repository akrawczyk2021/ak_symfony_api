<?php

declare(strict_types=1);

namespace App\Transformer;

class SimpleUserListTransformer
{
    public function transformCollectionToArray(array $userCollection): array
    {
        $userList = [];
        foreach ($userCollection as $user) {
            $userList[] = ['id' => $user->getId(), 'name' => $user->getName()];
        }

        return $userList;
    }
}
