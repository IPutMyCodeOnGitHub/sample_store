<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimpleSeller\CoreBundle\Entity\Order as BaseOrder;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */
class Order extends BaseOrder
{

}
