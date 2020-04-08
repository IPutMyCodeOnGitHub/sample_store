<?php

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use App\Services\CartService;
use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class CartServiceTest extends Unit
{
    /** @var CartService */
    private $cartService;
    /** @var EntityManager */
    private $entityManager;
    /** @var UserRepository*/
    private $userRepositoryMock;
    /** @var CartRepository */
    private $cartRepositoryMock;
    /** @var CartItemRepository*/
    private $cartItemRepositoryMock;
    private $productMock;
    private $userMock;
    private $testUserName;
    private $cartMock;
    private $testProductPrice;


    protected function _before()
    {
        $this->testUserName = 'user_1@mail.com';
        $this->userMock = $this->make(User::class, [
            'username' => $this->testUserName,
        ]);

        $this->testProductPrice = 100.0;
        $this->productMock = $this->make(Product::class, [
            'price' => $this->testProductPrice,
        ]);

        $this->entityManager = $this->makeEmpty(EntityManager::class, ['persist', 'flush']);
        $this->userRepositoryMock = $this->make(UserRepository::class, [
            'findOneByUsername' => $this->userMock]);
    }


    public function testAddCartItemToNewCart()
    {
        $this->cartRepositoryMock = $this->make(CartRepository::class, ['findByUser' => null]);
        $this->cartItemRepositoryMock = $this->make(CartItemRepository::class, ['findCartItem' => null]);

        $this->cartService = new CartService(
            $this->entityManager, $this->userRepositoryMock,
            $this->cartRepositoryMock, $this->cartItemRepositoryMock);

        $cartItem = $this->cartService->addCartItem($this->testUserName, $this->productMock);

        $this->cartMock = $this->make(Cart::class, [
            'customer' => $this->userMock
        ]);

        $this->assertSame(1, $cartItem->getQuantity());
        $this->assertSame($this->productMock, $cartItem->getProduct());
        $this->assertSame($this->testProductPrice, $cartItem->getPrice());
    }


    public function testAddCartItemToExistingCart()
    {
        $this->cartMock = $this->make(Cart::class, [
            'customer' => $this->userMock,
            'items' => new ArrayCollection()
        ]);

        $this->cartRepositoryMock = $this->make(CartRepository::class, ['findByUser' => $this->cartMock]);
        $this->cartItemRepositoryMock = $this->make(CartItemRepository::class, ['findCartItem' => null]);

        $this->cartService = new CartService(
            $this->entityManager, $this->userRepositoryMock,
            $this->cartRepositoryMock, $this->cartItemRepositoryMock);

        $cartItem = $this->cartService->addCartItem($this->testUserName, $this->productMock);

        $this->assertSame(1, $cartItem->getQuantity());
        $this->assertSame($this->productMock, $cartItem->getProduct());
        $this->assertSame($this->testProductPrice, $cartItem->getPrice());
    }


    public function testAddProductToCartItemInExistingCart()
    {
        $this->cartMock = $this->make(Cart::class, [
            'customer' => $this->userMock,
            'items' => new ArrayCollection()
        ]);

        $cartItemMock = $this->make(CartItem::class, [
            'product' => $this->productMock,
            'quantity' => 2,
            'price' => 200.0,
            'cart' => $this->cartMock
            ]);

        $this->cartRepositoryMock = $this->make(CartRepository::class, ['findByUser' => $this->cartMock]);
        $this->cartItemRepositoryMock = $this->make(CartItemRepository::class, ['findCartItem' => $cartItemMock]);

        $this->cartService = new CartService(
            $this->entityManager, $this->userRepositoryMock,
            $this->cartRepositoryMock, $this->cartItemRepositoryMock);

        $cartItem = $this->cartService->addCartItem($this->testUserName, $this->productMock);

        $this->assertSame(3, $cartItem->getQuantity());
        $this->assertSame($this->productMock, $cartItem->getProduct());
        $this->assertSame($this->testProductPrice * 3, $cartItem->getPrice());
    }
}



