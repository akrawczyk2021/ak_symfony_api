<?php

declare(strict_types=1);

namespace App\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Request\CreateCard;

class CreateCardParamConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $cardDTO = new CreateCard(
            $content['name'],
            $content['description'],
            $content['attack'],
            $content['defense'],
            $content['hp']
        );

        $request->attributes->set($configuration->getName(), $cardDTO);
    }

    public function supports(ParamConverter $configuration)
    {
        return CreateCard::class === $configuration->getClass();
    }
}
