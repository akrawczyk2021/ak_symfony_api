<?php

declare(strict_types=1);

namespace App\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Validator\CardDataValidator;
use App\Repository\CardRepository;
use App\Request\CreateCard;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateCardParamConverter implements ParamConverterInterface
{

    private $cardRepository;
    private $validator;

    public function __construct(CardRepository $repository, CardDataValidator $validator)
    {
        $this->validator = $validator;
        $this->cardRepository = $repository;
    }

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
