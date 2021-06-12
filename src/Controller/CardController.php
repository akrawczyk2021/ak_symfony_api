<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Card;
use App\Request\CreateCard;
use Codeception\Util\HttpCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;


class CardController extends AbstractController
{
    /**
     * @Route("/card",name="card_create",methods={"POST"})
     */
    public function addCard(CreateCard $createCard)
    {
        try {
            //$card = new Card();
            //$card->setName($createCard->getName());
            //$card->setDescription($createCard->getDescription());
            //$card->setAttack($createCard->getAttack());
            //$card->setDefense($createCard->getDefense());
            //$card->setHP($createCard->getHp());
            //$this->entityManager->persist($card);
            //$this->entityManager->flush();
        } catch (\Exception $ex) {
            throw new BadRequestException("Database insert error");
        }
        return $this->json([], HttpCode::CREATED);
    }
}
