<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;

/**
 * @Route("/my", name="user")
 */
class UserController extends AbstractFOSRestController
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
    public function ordersAction() //список заказов пользователя
    {
        $repository = $this->getDoctrine()->getManager()
            ->getRepository(Order::class);

        /** @var Order $products */
        $customer = $this->getUser();
        $orders = $repository->findBy(
            ['customer' => $customer]
        );

        $view = View::create();
        $view->setData($orders);
        return $this->handleView($view);
    }
}
