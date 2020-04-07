<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/auth/login", name="login.check")
     */
    public function index()
    {
        return new \RuntimeException("There is no place for you. Go away.");
    }

}
