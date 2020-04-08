<?php

namespace App\Services;

use App\DataTransferObject\CartToOrderDTO;
use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\CartRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

class OrderService
{
    private $entityManager;
    private $userRepository;
    private $cartRepository;
    private $orderRepository;
    private $orderItemRepository;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        CartRepository $cartRepository)
    {
        $this->entityManager = $em;
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
    }

    public function createOrderByCart(CartToOrderDTO $cartToOrderDTO)
    {
        $customer = $this->userRepository->find($cartToOrderDTO->getUserId());
        $cart = $this->cartRepository->findByUser($customer);

        if(!$cart){
            throw new RuntimeException("There is no products in cart to create an order.");
        }

        $order = new Order();
        $order->setCustomer($cart->getCustomer());
        $order->setAddress($cartToOrderDTO->getAddress());
        $order->setPhoneNumber($cartToOrderDTO->getPhoneNumber());
        $order->setComment($cartToOrderDTO->getComment());
        $order->setStatus(Order::ORDER_CLOSED);
        $this->entityManager->persist($order);

        $this->cartItemToOrderItem($cart, $order);
        $cart->setStatus(Cart::CART_CLOSED);

        $this->entityManager->flush();
        return $order;
    }

    private function cartItemToOrderItem(Cart $cart, Order $order): void
    {
        $cartItems = $cart->getItems();
        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItem(
                $order,
                $cartItem->getProduct(),
                $cartItem->getPrice(),
                $cartItem->getQuantity()
            );
            $order->addItem($orderItem);
        }
    }
}