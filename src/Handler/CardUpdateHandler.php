<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Card;
use App\Exception\NotUniqueCardnameException;
use App\Request\EditCard;
use App\Validator\CardDataValidator;

class CardUpdateHandler
{
    public function __construct(
        private CardDataValidator $validator
    ) {
    }

    /**
     * @throws NotUniqueCardnameException
     */
    public function handle(EditCard $editCard): void
    {

        $existingCard = $editCard->getCardToChange();

        if ($this->isNameChanged($existingCard, $editCard->getName())) {
            $this->validator->ensureNameIsUnique($editCard->getName());
        }

        $existingCard->setName($editCard->getName());
        $existingCard->setDescription($editCard->getDescription());
        $existingCard->setAttack($editCard->getAttack());
        $existingCard->setDefense($editCard->getDefense());
        $existingCard->setHp($editCard->getHp());
    }

    private function isNameChanged(Card $card, string $newName): bool
    {
        return strcmp($card->getName(), $newName) != 0;
    }
}
