<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Repository\UserRepository;
use App\Request\ShowUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowUserParamConverter implements ParamConverterInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $user = $this->userRepository->find((int)$request->get('id'));
        if (!$user) {
            throw new NotFoundHttpException("No user found");
        }
        $showUser = new ShowUser($user->getId(), $user->getName(), $user->getEmail());
        $request->attributes->set($configuration->getName(), $showUser);
    }

    public function supports(ParamConverter $configuration)
    {
        return ShowUser::class === $configuration->getClass();
    }
}
