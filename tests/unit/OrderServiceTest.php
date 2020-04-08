<?php

use App\DataTransferObject\CartToOrderDTO;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Services\OrderService;
use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class OrderServiceTest extends Unit
{
    private $entityManager;
    private $orderService;
    private $userRepositoryMock;
    /** @var CartRepository */
    private $cartRepositoryMock;
    /** @var CartToOrderDTO */
    private $cartToOrderDTOMock;
    private $userMock;

    protected function _before()
    {
        $this->userMock = $this->make(User::class, [
            'username' => 'user_1@mail.com',
        ]);

        $this->cartToOrderDTOMock = $this->make(CartToOrderDTO::class, [
            'userId' => 1,
            'address' => 'aleysk-city',
            'phoneNumber' => '9696969696'
        ]);

        $this->entityManager = $this->makeEmpty(EntityManager::class, ['persist', 'flush']);
        $this->userRepositoryMock = $this->make(UserRepository::class, ['find' => $this->userMock]);
    }


    public function testCreateOrderByCart()
    {
        $cartMock = $this->make(Cart::class, [
            'customer' => $this->userMock,
            'items' => new ArrayCollection(),
            'addItem'
        ]);

        $productMock = $this->make(Product::class);

        $cartItemMock = $this->make(CartItem::class, [
            'product' => $productMock,
            'price' => 200.0,
            'quantity' => 2,
            'cart' => $cartMock
        ]);
        $cartMock->addItem($cartItemMock);

        $this->cartRepositoryMock = $this->make(CartRepository::class, ['findByUser' => $cartMock]);
        $this->orderService = new OrderService($this->entityManager,
            $this->userRepositoryMock, $this->cartRepositoryMock);

        $order = $this->orderService->createOrderByCart($this->cartToOrderDTOMock);

        $this->assertSame($this->cartToOrderDTOMock->getAddress(), $order->getAddress());
        $this->assertSame($this->userMock, $order->getCustomer());
    }


    public function testCreateOrderWithoutCart()
    {
        $this->cartRepositoryMock = $this->make(CartRepository::class, ['findByUser' => null]);
        $this->orderService = new OrderService($this->entityManager,
            $this->userRepositoryMock, $this->cartRepositoryMock);

        $this->expectExceptionMessage("There is no products in cart to create an order.");
        $this->orderService->createOrderByCart($this->cartToOrderDTOMock);
    }
}