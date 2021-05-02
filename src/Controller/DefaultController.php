<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * Root Endpoint
     * @Route("/",name="homepage")
     * @return Response
     */
    public function index(): Response
    {
        return $this->json([
            'version' => '1.0',
            'name' => 'AK_SYMFONY_API',
        ]);
    }

    


}
