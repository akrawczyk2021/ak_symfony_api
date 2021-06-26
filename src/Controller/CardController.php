<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CardRepository;
use App\Request\CreateCard;
use App\Entity\Card;
use App\Exception\CardNotFoundException;
use App\Exception\NotUniqueCardnameException;
use App\Request\EditCard;
use App\Request\ShowCard;
use App\Validator\CardDataValidator;
use Codeception\Util\HttpCode;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CardRepository $repository,
        private CardDataValidator $validator
    ) {
    }

    /**
     * @Route("/card",name="card_create",methods={"POST"})
     */
    public function addCard(CreateCard $createCard): Response
    {
        try {
            $this->createCard($createCard);
            $this->entityManager->flush();
        } catch (NotUniqueCardnameException $e) {
            throw new BadRequestException($e->getMessage());
        }

        return $this->json([], HttpCode::CREATED);
    }

    private function createCard(CreateCard $createCard): void
    {
        $this->validator->ensureNameIsUnique($createCard->getName());

        $card = new Card(
            $createCard->getName(),
            $createCard->getHp(),
            $createCard->getAttack(),
            $createCard->getDefense(),
        );
        $card->setDescription($createCard->getDescription());

        $this->repository->add($card);
    }

    /**
     * Delete Card
     * @Route("/card/{id}",name="card_delete",methods={"DELETE"})
     */
    public function deleteCard(Card $card): Response
    {
        $this->entityManager->remove($card);
        $this->entityManager->flush();

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * Show Card
     * @Route("/card/{id}",name="card_show",methods={"GET"})
     */
    public function showCard(ShowCard $showCard): Response
    {
        try {
            $card = $this->repository->getById($showCard->getCardId());
        } catch (CardNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->json($card, Response::HTTP_OK);
    }

    /**
     * Edit Card
     * @Route("/card/{id}",name="edit_card",methods={"PUT"})
     */
    public function editCard(EditCard $editCard, Request $request): Response
    {
        try {
            $existingCard = $this->repository->getById((int)$request->get('id'));
        } catch (CardNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        try {
            $this->setCardNewValues($existingCard, $editCard);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new BadRequestException("Something went wrong");
        }

        return $this->json([], Response::HTTP_OK);
    }

    private function setCardNewValues(Card $existingCard, EditCard $editCard): void
    {
        if (strcmp($existingCard->getName(), $editCard->getName()) != 0) {
            $this->validator->ensureNameIsUnique($editCard->getName());
        }
        $existingCard->setName($editCard->getName());
        $existingCard->setDescription($editCard->getDescription());
        $existingCard->setAttack($editCard->getAttack());
        $existingCard->setDefense($editCard->getDefense());
        $existingCard->setHp($editCard->getHp());
    }
}
