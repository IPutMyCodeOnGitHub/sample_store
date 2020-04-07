<?php

namespace App\Controller;

use App\Repository\UserRepository;
use FOS\RestBundle\Context\Context;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;

/**
 * @Route("/my", name="customer")
 */
class UserController extends AbstractFOSRestController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/profile", name="profile", methods={"GET"})
     */
    public function profileAction()
    {
        $userName = $this->getUser()->getUsername();
        $user = $this->userRepository->findOneByUsername($userName);

        $view = new View();
        $context = new Context();
        $context->addGroup('profile');
        $view->setData($user);
        $view->setContext($context);

        return $this->handleView($view);
    }
}
