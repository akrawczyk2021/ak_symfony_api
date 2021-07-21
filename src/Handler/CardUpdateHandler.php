<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Card;
use App\Exception\NotUniqueCardnameException;
use App\Request\EditCard;
use App\Validator\CardDataValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CardUpdateHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CardDataValidator $validator
    ) {
    }

    public function handle(EditCard $editCard): void
    {
        $existingCard = $editCard->getCardToChange();

        try {

            if ($this->isNameChanged($existingCard, $editCard->getName())) {
                $this->validator->ensureNameIsUnique($editCard->getName());
            }

            $existingCard->setName($editCard->getName());
            $existingCard->setDescription($editCard->getDescription());
            $existingCard->setAttack($editCard->getAttack());
            $existingCard->setDefense($editCard->getDefense());
            $existingCard->setHp($editCard->getHp());

        } catch (NotUniqueCardnameException $e) {
            throw new BadRequestHttpException("Card name already exists");
        } catch (Exception $e) {
            throw new BadRequestHttpException("Something went wrong");
        }
    }

    private function isNameChanged(Card $card, string $newName): bool
    {
        return strcmp($card->getName(), $newName) != 0;
    }
}
