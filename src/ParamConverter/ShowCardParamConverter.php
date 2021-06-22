<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Repository\CardRepository;
use App\Request\ShowCard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowCardParamConverter implements ParamConverterInterface
{
    private CardRepository $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $card = $this->cardRepository->findOneById((int)$request->get('id'));

        $showCard = new ShowCard(
            (int)$request->get('id'),
            $card->getName(),
            $card->getDescription(),
            $card->getAttack(),
            $card->getDefense(),
            $card->getHp()
        );
        $request->attributes->set($configuration->getName(), $showCard);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return ShowCard::class === $configuration->getClass();
    }
}
