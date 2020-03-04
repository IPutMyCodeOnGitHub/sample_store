<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="user.profile", methods={"GET"})
     */
    public function profileAction()
    {
        return $this->json("");
    }

    /**
     * @Route("/orders", name="user.orders", methods={"GET"})
     */
    public function ordersAction()
    {
        return $this->json("");
    }
}
