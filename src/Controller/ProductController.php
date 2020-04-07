<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
 * @Route("/catalog", name="catalog")
 */
class ProductController extends AbstractFOSRestController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products", name="catalog.products", methods={"GET"})
     */
    public function productList()
    {
        $products = $this->productRepository->findAll();

        $view = new View();
        $context = new Context();
        $context->addGroup('product');
        $view->setData($products);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @Route("/products/{id<\d+>}", name="catalog.product", methods={"GET"})
     */
    public function showProduct(Product $product)
    {
        $view = new View();
        $context = new Context();
        $context->addGroup('product');
        $view->setData($product);
        $view->setContext($context);

        return $this->handleView($view);
    }
}
