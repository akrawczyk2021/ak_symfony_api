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

        if (
            $this->validator->isValidName($content['name'])
            && $this->validator->isValidEmail($content['email'])
            && $this->validator->isValidPassword($content['password'])
        ) {
            $userdto = new CreateUser($content['name'], $content['email'], $content['password']);
        } else {
            throw new BadRequestException("Wrong data");
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
