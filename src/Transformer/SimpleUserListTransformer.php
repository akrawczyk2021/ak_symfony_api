<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\User;

class SimpleUserListTransformer
{
    public function transformCollectionToArray(array $userCollection): array
    {
        $userList = [];
        foreach ($userCollection as $user) {
            if (!$user instanceof User) {
                throw new \LogicException('Input data is not a valid User Class');
            }
            $userList[] = ['id' => $user->getId(), 'name' => $user->getName()];
        }

        return $userList;
    }
}
