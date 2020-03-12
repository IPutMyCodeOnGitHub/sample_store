<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/catalog", name="catalog")
 */
class CatalogController extends AbstractFOSRestController
{
    /**
     * @Route("/categories", name="catalog.categories", methods={"GET"})
     * @Rest\View(serializerGroups={"category"})
     */
    public function categoriesAction() //список категорий
    {
        $repository = $this->getDoctrine()->getManager()
            ->getRepository(Category::class);

        /** @var Category $categories */
        $categories = $repository->findAll();

        $view = View::create();
        $view->setData($categories);
        return $this->handleView($view);
    }

    /**
     * @Route("/products", name="catalog.products", methods={"GET"})
     */
    public function productsAction() //список продуктов
    {
        $repository = $this->getDoctrine()->getManager()
            ->getRepository(Product::class);

        /** @var Product $products */
        $products = $repository->findAll();

        $view = View::create();
        $view->setData($products);
        return $this->handleView($view);
    }
}
