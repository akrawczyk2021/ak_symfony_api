<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Request\ShowCard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ShowCardParamConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration)
    {
        $cardId = $this->getCardId($request);

        $request->attributes->set($configuration->getName(), new ShowCard($cardId));
    }

    private function getCardId(Request $request): int
    {
        $cardId = $request->get('id');
        if ($cardId === null) {
            throw new BadRequestHttpException("Card id is required");
        }

        if (!is_numeric($cardId)) {
            throw new BadRequestHttpException("Card id must be numeric");
        }

        $cardId = (int)$cardId;
        if ($cardId <= 0) {
            throw new BadRequestHttpException("Card id must be greater then 0");
        }

        return $cardId;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return ShowCard::class === $configuration->getClass();
    }
}
