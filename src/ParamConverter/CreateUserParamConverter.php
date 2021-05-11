<?php

declare(strict_types=1);

namespace App\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateUserConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration)
    {
    }

    public function supports(ParamConverter $configuration)
    {
        return false;
    }
}
