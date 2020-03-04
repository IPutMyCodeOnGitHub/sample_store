<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiAuthController extends AbstractController
{
    /**
     * @Route("/api/auth", name="api.auth")
     */
    public function index()
    {
        return new \RuntimeException("There is no place for you. Go away.");
    }
}
