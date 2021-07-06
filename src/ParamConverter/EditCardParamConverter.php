<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Request\EditCard;
use App\Validator\CardDataValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class EditCardParamConverter implements ParamConverterInterface
{
    public function __construct(private CardDataValidator $validator)
    {
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $cardDTO = new EditCard(
            $this->getName($content),
            $this->getDescription($content),
            $this->getIntStat($content, 'attack'),
            $this->getIntStat($content, 'defense'),
            $this->getIntStat($content, 'hp'),
        );

        $request->attributes->set($configuration->getName(), $cardDTO);
    }

    private function getName(array $content): string
    {
        if (!$this->validator->isValidName($content['name'])) {
            throw new BadRequestException("Wrong value for Name field");
        }

        return $content['name'];
    }

    private function getDescription(array $content): string
    {
        if (!array_key_exists('description', $content)) {
            throw new BadRequestException("Field Description is missing");
        }
        if (!$this->validator->isValidDescription($content['description'])) {
            throw new BadRequestException("Wrong value for Description field");
        }
        
        return $content['description'];
    }

    private function getIntStat(array $content, string $statName): int
    {
        if (!array_key_exists($statName, $content)) {
            throw new BadRequestException("Field " . $statName . " is missing");
        }
        if (!$this->validator->isValidIntStat((int)$content[$statName])) {
            throw new BadRequestException("Wrong value for " . $statName . " field");
        }

        return (int)$content[$statName];
    }

    public function supports(ParamConverter $configuration): bool
    {
        return EditCard::class === $configuration->getClass();
    }
}
