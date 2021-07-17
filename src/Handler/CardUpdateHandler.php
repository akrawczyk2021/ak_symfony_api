<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Card;
use App\Exception\CardNotFoundException;
use App\Exception\NotUniqueCardnameException;
use App\Request\EditCard;
use App\Validator\CardDataValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CardUpdateHandler
{
    public function __construct(
        private EditCard $editCard,
        private EntityManagerInterface $entityManager,
        private CardDataValidator $validator
    ) {
    }

    public function handle(): void
    {
        $existingCard = $this->editCard->getCardToChange();

        try {

            if ($this->isNameChanged($existingCard, $this->editCard->getName())) {
                $this->validator->ensureNameIsUnique($this->editCard->getName());
            }

            $existingCard->setName($this->editCard->getName());
            $existingCard->setDescription($this->editCard->getDescription());
            $existingCard->setAttack($this->editCard->getAttack());
            $existingCard->setDefense($this->editCard->getDefense());
            $existingCard->setHp($this->editCard->getHp());

            $this->entityManager->flush();
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
