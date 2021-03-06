<?php

declare(strict_types=1);

namespace App\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Validator\CardDataValidator;
use App\Request\CreateCard;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateCardParamConverter implements ParamConverterInterface
{
    private array $content;

    public function __construct(private CardDataValidator $validator)
    {
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $this->content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $cardDTO = new CreateCard(
            $this->getName($this->content),
            $this->getDescription($this->content),
            $this->getIntStat($this->content, 'attack'),
            $this->getIntStat($this->content, 'defense'),
            $this->getIntStat($this->content, 'hp')
        );

        $request->attributes->set($configuration->getName(), $cardDTO);
    }

    public function supports(ParamConverter $configuration)
    {
        return CreateCard::class === $configuration->getClass();
    }

    private function getName(array $content): string
    {
        if ($this->validator->isValidName($content['name'])) {
            return $content['name'];
        } else {
            throw new BadRequestException("Wrong value for Name field");
        }
    }

    private function getDescription(array $content): string
    {
        if (!array_key_exists('description', $content)) {
            throw new BadRequestException("Field Description is missing");
        }
        if ($this->validator->isValidDescription($content['description'])) {
            return $content['description'];
        } else {
            throw new BadRequestException("Wrong value for Description field");
        }
    }

    private function getIntStat(array $content, string $statName): int
    {
        if (!array_key_exists($statName, $content)) {
            throw new BadRequestException("Field " . $statName . " is missing");
        }
        if ($this->validator->isValidIntStat((int)$content[$statName])) {
            return (int)$content[$statName];
        } else {
            throw new BadRequestException("Wrong value for " . $statName . " field");
        }
    }
}
