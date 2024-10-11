<?php

namespace App\Controller;

use Symfony\Component\Intl\Countries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'app_api_root')]
class RootController extends AbstractController
{
    #[Route('', name: 'app_api_root_index' , methods:['GET'])]
    public function index(Request $request): JsonResponse
    {
        return $this->json(data : [
            'status' => 'Server is running',
            'host' => $request->getHttpHost(),
            'protocol' => $request-> getScheme(),
        ]);
    }

    #[Route(path:'/ping', name: 'app_api_root_ping', methods:['GET'])]
    public function ping() : JsonResponse
    {
        return $this->json(data: [
            'message' => 'pong',
        ]);
    }

    #[Route(path:'/valtest', name: 'app_api_root_ping', methods:['GET'])]
    public function valtest() : JsonResponse
    {
        return $this->json(array_values(Countries::getAlpha3Codes()));
    }
}
