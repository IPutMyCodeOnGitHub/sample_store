<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            /** @var Category $category */
            $category = $this->getReference(Category::class . '_' . $i);
            $product = new Product('Product_' . $i,
                'Description_' . $i,
                $category,
                $i * 100 + $i);

            $manager->persist($product);
            $this->addReference(Product::class . '_' . $i, $product);
            $manager->flush();
        }
    }
}
