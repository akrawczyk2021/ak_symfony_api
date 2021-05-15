<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Repository\UserRepository;
use App\Request\CreateUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Validator\UserDataValidator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateUserConverter implements ParamConverterInterface
{
    private UserDataValidator $validator;
    private UserRepository $userRepository;

    public function __construct(UserDataValidator $validator, UserRepository $userRepository)
    {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (
            $this->validator->isValidName($content['name'])
            && $this->validator->isValidEmail($content['email'])
            && $this->validator->isValidPassword($content['password'])
        ) {
            $this->ensureEmailIsUnique($content['email']);
            $userdto = new CreateUser($content['name'], $content['email'], $content['password']);
        } else {
            throw new BadRequestException("Wrong data");
        }

        $request->attributes->set($configuration->getName(), $userdto);
    }

    public function supports(ParamConverter $configuration)
    {
        return CreateUser::class === $configuration->getClass();
    }

    public function ensureEmailIsUnique(string $email): void
    {
        if ($this->userRepository->findOneByEmail($email) !== null) {
            throw new BadRequestException("This email is already used");
        }
    }
}
