<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\CartRepository;
use App\Services\CartService;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my", name="customer")
 */
class CartController extends AbstractFOSRestController
{
    private $cartService;
    private $cartRepository;

    public function __construct(CartRepository $cartRepository, CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @Route("/cart", name="customer.cart", methods={"GET"})
     */
    public function showCartItems()
    {
        $customer = $this->getUser();
        $cart = $this->cartRepository->findOneBy([
            'customer' => $customer,
            'status' => Cart::CART_OPEN
        ]);

        $view = new View();
        $context = new Context();
        $context->addGroup('cart');
        $view->setData($cart);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @Route("/cart/products/{id<\d+>}", name="cart.add.product", methods={"POST"})
     */
    public function addCartItem(Product $product)
    {
        $customerName = $this->getUser()->getUsername();
        $cartItem = $this->cartService
            ->addCartItem($customerName, $product);

        $view = new View();
        $context = new Context();
        $context->addGroup('cartItem');
        $view->setData($cartItem);
        $view->setContext($context);

        return $this->handleView($view);
    }
}
