<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        return new JsonResponse(["code" => 400, "message" => "Bad Request"], 400, [], false);
    }
}
