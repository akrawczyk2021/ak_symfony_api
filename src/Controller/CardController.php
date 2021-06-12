<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use App\Request\CreateCard;
use Codeception\Util\HttpCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private CardRepository $repository)
    {
    }

    /**
     * @Route("/card",name="card_create",methods={"POST"})
     */
    public function addCard(CreateCard $createCard): Response
    {
        $this->createCard($createCard);

        $this->entityManager->flush();

        return $this->json([], HttpCode::CREATED);
    }

    private function createCard(CreateCard $createCard): void
    {
        $this->ensureUniqueName($createCard);

        $card = new Card(
            $createCard->getName(),
            $createCard->getHp(),
            $createCard->getAttack(),
            $createCard->getDefense(),
        );
        $card->setDescription($createCard->getDescription());

        $this->repository->add($card);
    }

    private function ensureUniqueName(CreateCard $createCard): void
    {
        $repository = $this->entityManager->getRepository(Card::class);

        $card = $repository->findOneBy(['name' => $createCard->getName()]);
        if ($card !== null) {
            throw new BadRequestException('Card name must be unique.');
        }
    }
}
