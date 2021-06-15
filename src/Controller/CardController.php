<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use App\Request\CreateCard;
use Codeception\Util\HttpCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Request\ShowCard;

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
        $this->repository->createCard($createCard);

        $this->entityManager->flush();

        return $this->json([], HttpCode::CREATED);
    }

    /**
     * Delete Card
     * @Route("/card/{name}",name="card_delete",methods={"DELETE"})
     */
    public function deleteCard(Card $card): Response
    {
        $this->entityManager->remove($card);
        $this->entityManager->flush();

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * Show Card
     * @Route("/card/{name}",name="card_show",methods={"GET"})
     */
    public function showCard(ShowCard $showCard): Response
    {
        $card = ['card' => $showCard];

        return $this->json($card, Response::HTTP_OK);
    }
}
