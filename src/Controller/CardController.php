<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CardRepository;
use App\Request\CreateCard;
use Codeception\Util\HttpCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $this->repository->createCard($createCard);

        $this->entityManager->flush();

        return $this->json([], HttpCode::CREATED);
    }
}
