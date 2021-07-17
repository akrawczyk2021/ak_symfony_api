<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Entity\Card;
use App\Exception\CardNotFoundException;
use App\Repository\CardRepository;
use App\Request\EditCard;
use App\Validator\CardDataValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EditCardParamConverter implements ParamConverterInterface
{
    public function __construct(
        private CardDataValidator $validator,
        private CardRepository $cardRepository
    ) {
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
            $this->getCardToChange($request)
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

    private function getCardToChange(Request $request): Card
    {
        $cardId = $request->get('id');
        if ($cardId === null) {
            throw new BadRequestHttpException("Card id is required");
        }

        if (!is_numeric($cardId)) {
            throw new BadRequestHttpException("Card id must be numeric");
        }

        $cardId = (int)$cardId;
        if ($cardId < 0) {
            throw new BadRequestHttpException("Card id must be greater then 0");
        }
        try {
            $existngCard = $this->cardRepository->getById($cardId);
        } catch (CardNotFoundException $e) {
            throw new BadRequestHttpException("Card not found");
        }

        return $existngCard;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return EditCard::class === $configuration->getClass();
    }
}
