<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Request\CreateUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Validator\UserDataValidator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateUserConverter implements ParamConverterInterface
{
    private UserDataValidator $validator;

    public function __construct(UserDataValidator $validator)
    {
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $userdto = new CreateUser();
        if ($this->validator->isValidName($content['name'])) {
            $userdto->setName($content['name']);
        } else {
            throw new BadRequestException("Name cannot be empty");
        }

        if ($this->validator->isValidEmail($content['email'])) {
            $userdto->setEmail($content['email']);
        } else {
            throw new BadRequestException("Email cannot be empty");
        }

        if ($this->validator->isValidPassword($content['password'])) {
            $userdto->setPassword($content['password']);
        } else {
            throw new BadRequestException("Wrong password");
        }

        $request->attributes->set($configuration->getName(), $userdto);
    }

    public function supports(ParamConverter $configuration)
    {

        if (null === $configuration->getClass()) {
            return false;
        }

        if ("App\Request\CreateUser" !== $configuration->getClass()) {
            return false;
        } else {
            return true;
        }
    }
}
