<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SimpleSeller\CoreBundle\Entity\Category as BaseCategory;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category extends BaseCategory
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category", cascade={"persist"})
     */
    protected $products;
}
