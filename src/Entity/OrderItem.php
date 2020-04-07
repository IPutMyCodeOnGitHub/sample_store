<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimpleSeller\CoreBundle\Entity\OrderItem as BaseOrderItem;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 */
class OrderItem extends BaseOrderItem
{
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }
}
