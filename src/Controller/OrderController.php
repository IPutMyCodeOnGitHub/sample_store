<?php


namespace App\Controller;

use App\DataTransferObject\CartToOrderDTO;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Services\OrderService;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my", name="customer")
 */
class OrderController extends AbstractFOSRestController
{
    private $orderService;
    private $orderRepository;
    private $userRepository;

    public function __construct(
        OrderService $orderService,
        UserRepository $userRepository,
        OrderRepository $orderRepository)
    {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/orders", name="customer.orders", methods={"GET"})
     */
    public function orderList()
    {
        $customer = $this->getUser();
        $orders = $this->orderRepository->findBy(['customer' => $customer]);

        $view = new View();
        $context = new Context();
        $context->addGroup('order');
        $view->setData($orders);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @Route("/orders", name="create.order", methods={"POST"})
     * @ParamConverter("cartToOrderDTO", converter="fos_rest.request_body")
     */
    public function createOrder(CartToOrderDTO $cartToOrderDTO)
    {
        $customerName = $this->getUser()->getUsername();
        $customer = $this->userRepository->findOneByUsername($customerName);
        $cartToOrderDTO->setUserId($customer->getId());

        $order = $this->orderService->createOrderByCart($cartToOrderDTO);
        $view = new View();
        $context = new Context();
        $context->addGroup('order');
        $view->setData($order);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @Route("/orders/{id<\d+>}", name="order.items", methods={"GET"})
     */
    public function showOrder(Order $order)
    {
        $view = new View();
        $context = new Context();
        $context->addGroup('order');
        $view->setData($order);
        $view->setContext($context);

        return $this->handleView($view);
    }
}