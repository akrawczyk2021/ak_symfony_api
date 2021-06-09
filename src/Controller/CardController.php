<?php

declare(strict_types=1);

namespace App\Controller;

use Codeception\Util\HttpCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CardController extends AbstractController
{
    /**
     * @Route("/card",name="card_create",methods={"POST"})
     */
    public function addCard()
    {
        return $this->json([],HttpCode::OK);
    }
}
