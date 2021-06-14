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
        //dump($content);
        //die();
        if (
            $this->validator->isValidName($content['name'])
            && $this->validator->isValidIntStat((int)$content['hp'])
            && $this->validator->isValidIntStat((int)$content['attack'])
            && $this->validator->isValidIntStat((int)$content['defense'])
        ) {
            $this->ensureNameIsUnique($content['name']);
            $cardDTO = new CreateCard($content['name'], $content['description'], (int)$content['attack'], (int)$content['defense'], (int)$content['hp']);
        } else {
            throw new BadRequestException("Wrong data");
        }

        $request->attributes->set($configuration->getName(), $cardDTO);
    }

    public function supports(ParamConverter $configuration)
    {
        return CreateCard::class === $configuration->getClass();
    }

    private function ensureNameIsUnique(string $name): void
    {
        if ($this->cardRepository->findOneByName($name)) {
            throw new BadRequestException("Name is already in use");
        }
    }
}
