<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/catalog", name="catalog")
 */
class CatalogController extends AbstractController
{
    /**
     * @Route("/categories", name="catalog.categories", methods={"GET"})
     */
    public function categoriesAction()
    {
        return $this->json("");
    }

    /**
     * @Route("/products", name="catalog.products", methods={"GET"})
     */
    public function productsAction()
    {
        return $this->json("");
    }
}
