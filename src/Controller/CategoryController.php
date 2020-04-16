<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
 * @Route("/catalog", name="catalog")
 */
class CategoryController extends AbstractFOSRestController
{
    private $categoryRepository;
    private $productRepository;

    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/categories", name="catalog.categories", methods={"GET"})
     */
    public function categoryList()
    {
        $categories = $this->categoryRepository->findAll();

        $view = new View();
        $context = new Context();
        $context->addGroup('category');
        $view->setData($categories);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @Route("/categories/{id<\d+>}", name="catalog.category", methods={"GET"})
     */
    public function showCategory(Category $category)
    {
        $products = $this->productRepository->findBy(['category' => $category]);

        $view = new View();
        $context = new Context();
        $context->addGroup('productByCategory');
        $view->setData($products);
        $view->setContext($context);

        return $this->handleView($view);
    }
}
