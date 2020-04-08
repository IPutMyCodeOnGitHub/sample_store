<?php

namespace App\Services;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    private $entityManager;
    private $userRepository;
    private $cartRepository;
    private $cartItemRepository;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository)
    {
        $this->entityManager = $em;
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
    }

    public function addCartItemToNewCart(User $customer, Product $product)
    {
        $cart = new Cart($customer);
        $cartItem = new CartItem($cart, $product, $product->getPrice(), 1);
        $cart->addItem($cartItem);

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cartItem;
    }


    public function addCartItem(string $customerName, Product $product)
    {
        $customer = $this->userRepository->findOneByUsername($customerName);
        $cart = $this->cartRepository->findByUser($customer);

        if (!$cart){
            return $this->addCartItemToNewCart($customer, $product);
        }

        $cartItem = $this->cartItemRepository->findCartItem($cart, $product);
        if (!$cartItem) {
            $cartItem = new CartItem($cart, $product, $product->getPrice(), 1);
            $cart->addItem($cartItem);
        } else {
            $quantity = $cartItem->getQuantity() + 1;
            $price = $product->getPrice() * $quantity;
            $cartItem->setQuantity($quantity);
            $cartItem->setPrice($price);
        }

        $this->entityManager->flush();

        return $cartItem;
    }
}