<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimpleSeller\CoreBundle\Entity\Category as BaseCategory;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category extends BaseCategory
{

}
